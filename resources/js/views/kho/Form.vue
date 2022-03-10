<template>
  <el-row>
    <el-col :span="24">
      <el-card>
        <div slot="header">
          <template v-if="$route.params.id">
            {{ $t('route.kho_edit') }}
          </template>
          <template v-else>
            {{ $t('route.kho_create') }}
          </template>
        </div>
        <el-form ref="kho" v-loading="loading.form" :model="form" :rules="rules" label-position="top">
        <el-form-item
          data-generator="ten_kho"
          :label="$t('table.kho.ten_kho')"
          prop="ten_kho"
          :error="errors.ten_kho && errors.ten_kho[0]"
          >
            <el-input
              v-model="form.ten_kho"
              name="ten_kho"
              :placeholder="$t('table.kho.ten_kho')"
              maxlength="191"
              show-word-limit
            />
          </el-form-item>
          <el-form-item
          data-generator="dia_chi"
          :label="$t('table.kho.dia_chi')"
          prop="dia_chi"
          :error="errors.dia_chi && errors.dia_chi[0]"
          >
            <el-input
              v-model="form.dia_chi"
              name="dia_chi"
              :placeholder="$t('table.kho.dia_chi')"
              maxlength="191"
              show-word-limit
            />
          </el-form-item>
          <el-form-item
          data-generator="mo_ta"
          :label="$t('table.kho.mo_ta')"
          prop="mo_ta"
          :error="errors.mo_ta && errors.mo_ta[0]"
          >
            <el-input
              v-model="form.mo_ta"
              name="mo_ta"
              :placeholder="$t('table.kho.mo_ta')"
              maxlength="191"
              show-word-limit
            />
          </el-form-item>
          <el-form-item
          data-generator="ma_kho"
          :label="$t('table.kho.ma_kho')"
          prop="ma_kho"
          :error="errors.ma_kho && errors.ma_kho[0]"
          >
            <el-input
              v-model="form.ma_kho"
              name="ma_kho"
              :placeholder="$t('table.kho.ma_kho')"
              maxlength="191"
              show-word-limit
            />
          </el-form-item>
          <!--{{$FROM_ITEM_NOT_DELETE_THIS_LINE$}}-->
          <el-form-item class="tw-flex tw-justify-end">
            <router-link v-slot="{ href, navigate }" :to="{ name: 'Kho' }" custom>
              <a :href="href" class="el-button el-button--info is-plain" @click="navigate">{{ $t('button.cancel') }}</a>
            </router-link>
            <template v-if="$route.params.id">
              <el-button
                :loading="loading.button"
                type="primary"
                icon="el-icon-edit"
                @click="() => update('kho')"
              >
                {{ $t('button.update') }}
              </el-button>
            </template>
            <template v-else>
              <el-button
                :loading="loading.button"
                type="success"
                icon="el-icon-plus"
                @click="() => store('kho')"
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
import KhoResource from '@/api/v1/kho';
// {{$IMPORT_COMPONENT_NOT_DELETE_THIS_LINE$}}

const khoResource = new KhoResource();

export default {
  components: {
    // {{$IMPORT_COMPONENT_NAME_NOT_DELETE_THIS_LINE$}}
  },
  mixins: [GlobalForm],
  data() {
    return {
      form: {
        id: '',
        ten_kho: '',
        dia_chi: '',
        mo_ta: '',
        ma_kho: '',
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
          data: { data: kho },
        } = await khoResource.get(id);
        this.form = kho;
      }
      this.loading.form = false;
    } catch (e) {
      this.loading.form = false;
    }
  },
  methods: {
    store(kho) {
      this.$refs[kho].validate((valid, errors) => {
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
            await khoResource.store(this.form);
            this.$message({
              showClose: true,
              message: this.$t('messages.create'),
              type: 'success',
            });
            this.loading.button = false;
            await this.$router.push({ name: 'Kho' });
          } catch (e) {
            this.loading.button = false;
          }
        });
      });
    },
    update(kho) {
      this.$refs[kho].validate((valid, errors) => {
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
            await khoResource.update(this.$route.params.id, this.form);
            this.$message({
              showClose: true,
              message: this.$t('messages.update'),
              type: 'success',
            });
            this.loading.button = false;
            await this.$router.push({ name: 'Kho' });
          } catch (e) {
            this.loading.button = false;
          }
        });
      });
    },
  },
};
</script>
