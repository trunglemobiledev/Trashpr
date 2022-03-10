<template>
  <el-row>
    <el-col :span="24">
      <el-card>
        <div slot="header">
          <template v-if="$route.params.id">
            {{ $t('route.thuong_hieu_edit') }}
          </template>
          <template v-else>
            {{ $t('route.thuong_hieu_create') }}
          </template>
        </div>
        <el-form ref="thuongHieu" v-loading="loading.form" :model="form" :rules="rules" label-position="top">
        <el-form-item
          data-generator="ten_hang"
          :label="$t('table.thuong_hieu.ten_hang')"
          prop="ten_hang"
          :error="errors.ten_hang && errors.ten_hang[0]"
          >
            <el-input
              v-model="form.ten_hang"
              name="ten_hang"
              :placeholder="$t('table.thuong_hieu.ten_hang')"
              maxlength="191"
              show-word-limit
            />
          </el-form-item>
          <el-form-item
          data-generator="mo_ta"
          :label="$t('table.thuong_hieu.mo_ta')"
          prop="mo_ta"
          :error="errors.mo_ta && errors.mo_ta[0]"
          >
            <el-input
              v-model="form.mo_ta"
              name="mo_ta"
              :placeholder="$t('table.thuong_hieu.mo_ta')"
              maxlength="191"
              show-word-limit
            />
          </el-form-item>
          <!--{{$FROM_ITEM_NOT_DELETE_THIS_LINE$}}-->
          <el-form-item class="tw-flex tw-justify-end">
            <router-link v-slot="{ href, navigate }" :to="{ name: 'ThuongHieu' }" custom>
              <a :href="href" class="el-button el-button--info is-plain" @click="navigate">{{ $t('button.cancel') }}</a>
            </router-link>
            <template v-if="$route.params.id">
              <el-button
                :loading="loading.button"
                type="primary"
                icon="el-icon-edit"
                @click="() => update('thuongHieu')"
              >
                {{ $t('button.update') }}
              </el-button>
            </template>
            <template v-else>
              <el-button
                :loading="loading.button"
                type="success"
                icon="el-icon-plus"
                @click="() => store('thuongHieu')"
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
import ThuongHieuResource from '@/api/v1/thuong-hieu';
// {{$IMPORT_COMPONENT_NOT_DELETE_THIS_LINE$}}

const thuongHieuResource = new ThuongHieuResource();

export default {
  components: {
    // {{$IMPORT_COMPONENT_NAME_NOT_DELETE_THIS_LINE$}}
  },
  mixins: [GlobalForm],
  data() {
    return {
      form: {
        id: '',
        ten_hang: '',
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
          data: { data: thuongHieu },
        } = await thuongHieuResource.get(id);
        this.form = thuongHieu;
      }
      this.loading.form = false;
    } catch (e) {
      this.loading.form = false;
    }
  },
  methods: {
    store(thuongHieu) {
      this.$refs[thuongHieu].validate((valid, errors) => {
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
            await thuongHieuResource.store(this.form);
            this.$message({
              showClose: true,
              message: this.$t('messages.create'),
              type: 'success',
            });
            this.loading.button = false;
            await this.$router.push({ name: 'ThuongHieu' });
          } catch (e) {
            this.loading.button = false;
          }
        });
      });
    },
    update(thuongHieu) {
      this.$refs[thuongHieu].validate((valid, errors) => {
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
            await thuongHieuResource.update(this.$route.params.id, this.form);
            this.$message({
              showClose: true,
              message: this.$t('messages.update'),
              type: 'success',
            });
            this.loading.button = false;
            await this.$router.push({ name: 'ThuongHieu' });
          } catch (e) {
            this.loading.button = false;
          }
        });
      });
    },
  },
};
</script>
