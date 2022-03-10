<template>
  <el-row>
    <el-col :span="24">
      <el-card>
        <div slot="header">
          <template v-if="$route.params.id">
            {{ $t('route.nhap_kho_edit') }}
          </template>
          <template v-else>
            {{ $t('route.nhap_kho_create') }}
          </template>
        </div>
        <el-form ref="nhapKho" v-loading="loading.form" :model="form" :rules="rules" label-position="top">
          <el-form-item
            data-generator="ngay_nhap"
            :label="$t('table.nhap_kho.ngay_nhap')"
            prop="ngay_nhap"
            :error="errors.ngay_nhap && errors.ngay_nhap[0]"
          >
            <el-date-picker
              v-model="form.ngay_nhap"
              name="ngay_nhap"
              type="datetime"
              :placeholder="$t('table.nhap_kho.ngay_nhap')"
              value-format="yyyy-MM-dd HH:mm:ss"
            />
          </el-form-item>
          <el-form-item
            data-generator="so_luong"
            :label="$t('table.nhap_kho.so_luong')"
            prop="so_luong"
            :error="errors.so_luong && errors.so_luong[0]"
          >
            <el-input-number v-model="form.so_luong" name="so_luong" :placeholder="$t('table.nhap_kho.so_luong')" />
          </el-form-item>
          <el-form-item
            data-generator="ma_phieu_nhap"
            :label="$t('table.nhap_kho.ma_phieu_nhap')"
            prop="ma_phieu_nhap"
            :error="errors.ma_phieu_nhap && errors.ma_phieu_nhap[0]"
          >
            <el-input
              v-model="form.ma_phieu_nhap"
              name="ma_phieu_nhap"
              :placeholder="$t('table.nhap_kho.ma_phieu_nhap')"
              maxlength="191"
              show-word-limit
            />
          </el-form-item>
          <el-form-item
            data-generator="sanpham_id"
            :label="$t('route.sanpham')"
            prop="sanpham_id"
            :error="errors.sanpham_id && errors.sanpham_id[0]"
          >
            <el-select
              v-model="form.sanpham_id"
              name="sanpham_id"
              multiple
              filterable
              :placeholder="$t('route.sanpham')"
              class="tw-w-full"
            >
              <el-option
                v-for="(item, index) in sanphamList"
                :key="'sanpham_' + index"
                :label="item.ma_san_pham"
                :value="item.id"
              />
            </el-select>
          </el-form-item>
          <el-form-item
          data-generator="kho_id"
          :label="$t('route.kho')"
          prop="kho_id"
          :error="errors.kho_id && errors.kho_id[0]"
          >
            <el-select
              v-model="form.kho_id"
              name="kho_id"
              filterable
              :placeholder="$t('route.kho')"
              class="tw-w-full"
            >
              <el-option
                v-for="(item, index) in khoList"
                :key="'kho_' + index"
                :label="item.ten_kho"
                :value="item.id"
              />
            </el-select>
          </el-form-item>
            <!--{{$FROM_ITEM_NOT_DELETE_THIS_LINE$}}-->
          <el-form-item class="tw-flex tw-justify-end">
            <router-link v-slot="{ href, navigate }" :to="{ name: 'NhapKho' }" custom>
              <a :href="href" class="el-button el-button--info is-plain" @click="navigate">{{ $t('button.cancel') }}</a>
            </router-link>
            <template v-if="$route.params.id">
              <el-button :loading="loading.button" type="primary" icon="el-icon-edit" @click="() => update('nhapKho')">
                {{ $t('button.update') }}
              </el-button>
            </template>
            <template v-else>
              <el-button :loading="loading.button" type="success" icon="el-icon-plus" @click="() => store('nhapKho')">
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
import NhapKhoResource from '@/api/v1/nhap-kho';
import SanphamResource from '@/api/v1/sanpham';
import KhoResource from '@/api/v1/kho';
// {{$IMPORT_COMPONENT_NOT_DELETE_THIS_LINE$}}

const nhapKhoResource = new NhapKhoResource();
const khoResource = new KhoResource();
const sanphamResource = new SanphamResource();

export default {
  components: {
    // {{$IMPORT_COMPONENT_NAME_NOT_DELETE_THIS_LINE$}}
  },
  mixins: [GlobalForm],
  data() {
    return {
      form: {
          id: '',
        ngay_nhap: '',
        so_luong: '',
        ma_phieu_nhap: '',
        sanpham_id: '',
        kho_id: '',
 }, // {{$$}}
      loading: {
        form: false,
        button: false,
      },
      sanphamList: [],
      khoList: [],
      // {{$DATA_NOT_DELETE_THIS_LINE$}}
    };
  },
  computed: {
    // not rename rules
    rules() {
      return {
        kho_id: [
          { required: true, message: this.$t('validation.required', { attribute: this.$t('route.kho') }), trigger: ['change'] },
        ],
        // {{$RULES_NOT_DELETE_THIS_LINE$}}
      };
    },
  },
  async created() {
    try {
      this.loading.form = true;
      const { id } = this.$route.params;
      const {
        data: { data: sanpham },
      } = await sanphamResource.getSanpham();
      this.sanphamList = sanpham;
      const {
        data: { data: kho },
      } = await khoResource.getKho();
      this.khoList = kho;
// {{$CREATED_NOT_DELETE_THIS_LINE$}}
      if (id) {
        const {
          data: { data: nhapKho },
        } = await nhapKhoResource.get(id);
        this.form = nhapKho;
      }
      this.loading.form = false;
    } catch (e) {
      this.loading.form = false;
    }
  },
  methods: {
    store(nhapKho) {
      this.$refs[nhapKho].validate((valid, errors) => {
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
            await nhapKhoResource.store(this.form);
            this.$message({
              showClose: true,
              message: this.$t('messages.create'),
              type: 'success',
            });
            this.loading.button = false;
            await this.$router.push({ name: 'NhapKho' });
          } catch (e) {
            this.loading.button = false;
          }
        });
      });
    },
    update(nhapKho) {
      this.$refs[nhapKho].validate((valid, errors) => {
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
            await nhapKhoResource.update(this.$route.params.id, this.form);
            this.$message({
              showClose: true,
              message: this.$t('messages.update'),
              type: 'success',
            });
            this.loading.button = false;
            await this.$router.push({ name: 'NhapKho' });
          } catch (e) {
            this.loading.button = false;
          }
        });
      });
    },
  },
};
</script>
