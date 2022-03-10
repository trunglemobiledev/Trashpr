<template>
  <el-row>
    <el-col :span="24">
      <el-card>
        <div slot="header">
          <template v-if="$route.params.id">
            {{ $t('route.nhac_cung_cap_edit') }}
          </template>
          <template v-else>
            {{ $t('route.nhac_cung_cap_create') }}
          </template>
        </div>
        <el-form ref="nhacCungCap" v-loading="loading.form" :model="form" :rules="rules" label-position="top">
        <el-form-item
          data-generator="man_nha_cung_cap"
          :label="$t('table.nhac_cung_cap.man_nha_cung_cap')"
          prop="man_nha_cung_cap"
          :error="errors.man_nha_cung_cap && errors.man_nha_cung_cap[0]"
          >
            <el-input
              v-model="form.man_nha_cung_cap"
              name="man_nha_cung_cap"
              :placeholder="$t('table.nhac_cung_cap.man_nha_cung_cap')"
              maxlength="191"
              show-word-limit
            />
          </el-form-item>
          <el-form-item
          data-generator="ten_nhac_cung_cap"
          :label="$t('table.nhac_cung_cap.ten_nhac_cung_cap')"
          prop="ten_nhac_cung_cap"
          :error="errors.ten_nhac_cung_cap && errors.ten_nhac_cung_cap[0]"
          >
            <el-input
              v-model="form.ten_nhac_cung_cap"
              name="ten_nhac_cung_cap"
              :placeholder="$t('table.nhac_cung_cap.ten_nhac_cung_cap')"
              maxlength="191"
              show-word-limit
            />
          </el-form-item>
          <el-form-item
          data-generator="dia_chi"
          :label="$t('table.nhac_cung_cap.dia_chi')"
          prop="dia_chi"
          :error="errors.dia_chi && errors.dia_chi[0]"
          >
            <el-input
              v-model="form.dia_chi"
              name="dia_chi"
              :placeholder="$t('table.nhac_cung_cap.dia_chi')"
              maxlength="191"
              show-word-limit
            />
          </el-form-item>
          <el-form-item
          data-generator="so_dien_thoai"
          :label="$t('table.nhac_cung_cap.so_dien_thoai')"
          prop="so_dien_thoai"
          :error="errors.so_dien_thoai && errors.so_dien_thoai[0]"
          >
            <el-input
              v-model="form.so_dien_thoai"
              name="so_dien_thoai"
              :placeholder="$t('table.nhac_cung_cap.so_dien_thoai')"
              maxlength="191"
              show-word-limit
            />
          </el-form-item>
          <el-form-item
          data-generator="tk_ngan_hang"
          :label="$t('table.nhac_cung_cap.tk_ngan_hang')"
          prop="tk_ngan_hang"
          :error="errors.tk_ngan_hang && errors.tk_ngan_hang[0]"
          >
            <el-input
              v-model="form.tk_ngan_hang"
              name="tk_ngan_hang"
              :placeholder="$t('table.nhac_cung_cap.tk_ngan_hang')"
              maxlength="191"
              show-word-limit
            />
          </el-form-item>
          <!--{{$FROM_ITEM_NOT_DELETE_THIS_LINE$}}-->
          <el-form-item class="tw-flex tw-justify-end">
            <router-link v-slot="{ href, navigate }" :to="{ name: 'NhacCungCap' }" custom>
              <a :href="href" class="el-button el-button--info is-plain" @click="navigate">{{ $t('button.cancel') }}</a>
            </router-link>
            <template v-if="$route.params.id">
              <el-button
                :loading="loading.button"
                type="primary"
                icon="el-icon-edit"
                @click="() => update('nhacCungCap')"
              >
                {{ $t('button.update') }}
              </el-button>
            </template>
            <template v-else>
              <el-button
                :loading="loading.button"
                type="success"
                icon="el-icon-plus"
                @click="() => store('nhacCungCap')"
              >
                {{ $t('button.create') }}
              </el-button>
            </template>
          </el-form-item>
        </el-form>
      </el-card>
    </el-col>
  </el-row>
</template>

<script>
import GlobalForm from '@/plugins/mixins/global-form';
import NhacCungCapResource from '@/api/v1/nhac-cung-cap';
// {{$IMPORT_COMPONENT_NOT_DELETE_THIS_LINE$}}

const nhacCungCapResource = new NhacCungCapResource();

export default {
  components: {
    // {{$IMPORT_COMPONENT_NAME_NOT_DELETE_THIS_LINE$}}
  },
  mixins: [GlobalForm],
  data() {
    return {
      form: {
        id: '',
        man_nha_cung_cap: '',
        ten_nhac_cung_cap: '',
        dia_chi: '',
        so_dien_thoai: '',
        tk_ngan_hang: '',
      }, // {{$$}}
      loading: {
        form: false,
        button: false,
      },
      // {{$DATA_NOT_DELETE_THIS_LINE$}}
    };
  },
  computed: {
    // not rename rules
    rules() {
      return {
        // {{$RULES_NOT_DELETE_THIS_LINE$}}
      };
    },
  },
  async created() {
    try {
      this.loading.form = true;
      const { id } = this.$route.params;
      // {{$CREATED_NOT_DELETE_THIS_LINE$}}
      if (id) {
        const {
          data: { data: nhacCungCap },
        } = await nhacCungCapResource.get(id);
        this.form = nhacCungCap;
      }
      this.loading.form = false;
    } catch (e) {
      this.loading.form = false;
    }
  },
  methods: {
    store(nhacCungCap) {
      this.$refs[nhacCungCap].validate((valid, errors) => {
        if (this.scrollToError(valid, errors)) {
          return;
        }
        this.$confirm(this.$t('common.popup.create'), {
          confirmButtonText: this.$t('button.create'),
          cancelButtonText: this.$t('button.cancel'),
          type: 'warning',
          center: true,
        }).then(async () => {
          try {
            this.loading.button = true;
            await nhacCungCapResource.store(this.form);
            this.$message({
              showClose: true,
              message: this.$t('messages.create'),
              type: 'success',
            });
            this.loading.button = false;
            await this.$router.push({ name: 'NhacCungCap' });
          } catch (e) {
            this.loading.button = false;
          }
        });
      });
    },
    update(nhacCungCap) {
      this.$refs[nhacCungCap].validate((valid, errors) => {
        if (this.scrollToError(valid, errors)) {
          return;
        }
        this.$confirm(this.$t('common.popup.update'), {
          confirmButtonText: this.$t('button.update'),
          cancelButtonText: this.$t('button.cancel'),
          type: 'warning',
          center: true,
        }).then(async () => {
          try {
            this.loading.button = true;
            await nhacCungCapResource.update(this.$route.params.id, this.form);
            this.$message({
              showClose: true,
              message: this.$t('messages.update'),
              type: 'success',
            });
            this.loading.button = false;
            await this.$router.push({ name: 'NhacCungCap' });
          } catch (e) {
            this.loading.button = false;
          }
        });
      });
    },
  },
};
</script>
