<template>
  <el-row>
    <el-col :span="24">
      <el-card>
        <div slot="header">
          <template v-if="$route.params.id">
            {{ $t('route.danh_muc_edit') }}
          </template>
          <template v-else>
            {{ $t('route.danh_muc_create') }}
          </template>
        </div>
        <el-form ref="danhMuc" v-loading="loading.form" :model="form" :rules="rules" label-position="top">
        <el-form-item
          data-generator="ten_danh_muc"
          :label="$t('table.danh_muc.ten_danh_muc')"
          prop="ten_danh_muc"
          :error="errors.ten_danh_muc && errors.ten_danh_muc[0]"
          >
            <el-input
              v-model="form.ten_danh_muc"
              name="ten_danh_muc"
              :placeholder="$t('table.danh_muc.ten_danh_muc')"
              maxlength="191"
              show-word-limit
            />
          </el-form-item>
          <el-form-item
          data-generator="mo_ta"
          :label="$t('table.danh_muc.mo_ta')"
          prop="mo_ta"
          :error="errors.mo_ta && errors.mo_ta[0]"
          >
            <el-input
              v-model="form.mo_ta"
              name="mo_ta"
              :placeholder="$t('table.danh_muc.mo_ta')"
              maxlength="191"
              show-word-limit
            />
          </el-form-item>
          <!--{{$FROM_ITEM_NOT_DELETE_THIS_LINE$}}-->
          <el-form-item class="tw-flex tw-justify-end">
            <router-link v-slot="{ href, navigate }" :to="{ name: 'DanhMuc' }" custom>
              <a :href="href" class="el-button el-button--info is-plain" @click="navigate">{{ $t('button.cancel') }}</a>
            </router-link>
            <template v-if="$route.params.id">
              <el-button
                :loading="loading.button"
                type="primary"
                icon="el-icon-edit"
                @click="() => update('danhMuc')"
              >
                {{ $t('button.update') }}
              </el-button>
            </template>
            <template v-else>
              <el-button
                :loading="loading.button"
                type="success"
                icon="el-icon-plus"
                @click="() => store('danhMuc')"
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
import DanhMucResource from '@/api/v1/danh-muc';
// {{$IMPORT_COMPONENT_NOT_DELETE_THIS_LINE$}}

const danhMucResource = new DanhMucResource();

export default {
  components: {
    // {{$IMPORT_COMPONENT_NAME_NOT_DELETE_THIS_LINE$}}
  },
  mixins: [GlobalForm],
  data() {
    return {
      form: {
        id: '',
        ten_danh_muc: '',
        mo_ta: '',
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
          data: { data: danhMuc },
        } = await danhMucResource.get(id);
        this.form = danhMuc;
      }
      this.loading.form = false;
    } catch (e) {
      this.loading.form = false;
    }
  },
  methods: {
    store(danhMuc) {
      this.$refs[danhMuc].validate((valid, errors) => {
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
            await danhMucResource.store(this.form);
            this.$message({
              showClose: true,
              message: this.$t('messages.create'),
              type: 'success',
            });
            this.loading.button = false;
            await this.$router.push({ name: 'DanhMuc' });
          } catch (e) {
            this.loading.button = false;
          }
        });
      });
    },
    update(danhMuc) {
      this.$refs[danhMuc].validate((valid, errors) => {
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
            await danhMucResource.update(this.$route.params.id, this.form);
            this.$message({
              showClose: true,
              message: this.$t('messages.update'),
              type: 'success',
            });
            this.loading.button = false;
            await this.$router.push({ name: 'DanhMuc' });
          } catch (e) {
            this.loading.button = false;
          }
        });
      });
    },
  },
};
</script>
