<template>
  <el-row>
    <el-col :span="24">
      <el-card>
        <div slot="header">
          <template v-if="$route.params.id">
            {{ $t('route.sanpham_edit') }}
          </template>
          <template v-else>
            {{ $t('route.sanpham_create') }}
          </template>
        </div>
        <el-form ref="sanpham" v-loading="loading.form" :model="form" :rules="rules" label-position="top">
          <el-form-item
            data-generator="ma_san_pham"
            :label="$t('table.sanpham.ma_san_pham')"
            prop="ma_san_pham"
            :error="errors.ma_san_pham && errors.ma_san_pham[0]"
          >
            <el-input
              v-model="form.ma_san_pham"
              name="ma_san_pham"
              :placeholder="$t('table.sanpham.ma_san_pham')"
              maxlength="191"
              show-word-limit
            />
          </el-form-item>
          <el-form-item
            data-generator="ten_san_pham"
            :label="$t('table.sanpham.ten_san_pham')"
            prop="ten_san_pham"
            :error="errors.ten_san_pham && errors.ten_san_pham[0]"
          >
            <el-input
              v-model="form.ten_san_pham"
              name="ten_san_pham"
              :placeholder="$t('table.sanpham.ten_san_pham')"
              maxlength="191"
              show-word-limit
            />
          </el-form-item>
          <el-form-item
            data-generator="gia_nhap"
            :label="$t('table.sanpham.gia_nhap')"
            prop="gia_nhap"
            :error="errors.gia_nhap && errors.gia_nhap[0]"
          >
            <el-input-number v-model="form.gia_nhap" name="gia_nhap" :placeholder="$t('table.sanpham.gia_nhap')" />
          </el-form-item>
          <el-form-item
            data-generator="gia_ban"
            :label="$t('table.sanpham.gia_ban')"
            prop="gia_ban"
            :error="errors.gia_ban && errors.gia_ban[0]"
          >
            <el-input-number v-model="form.gia_ban" name="gia_ban" :placeholder="$t('table.sanpham.gia_ban')" />
          </el-form-item>
          <el-form-item
            data-generator="ten_khach_ban"
            :label="$t('table.sanpham.ten_khach_ban')"
            prop="ten_khach_ban"
            :error="errors.ten_khach_ban && errors.ten_khach_ban[0]"
          >
            <el-input
              v-model="form.ten_khach_ban"
              name="ten_khach_ban"
              :placeholder="$t('table.sanpham.ten_khach_ban')"
              maxlength="191"
              show-word-limit
            />
          </el-form-item>
          <el-form-item
            data-generator="so_dien_thoai_khach_ban"
            :label="$t('table.sanpham.so_dien_thoai_khach_ban')"
            prop="so_dien_thoai_khach_ban"
            :error="errors.so_dien_thoai_khach_ban && errors.so_dien_thoai_khach_ban[0]"
          >
            <el-input
              v-model="form.so_dien_thoai_khach_ban"
              name="so_dien_thoai_khach_ban"
              :placeholder="$t('table.sanpham.so_dien_thoai_khach_ban')"
              maxlength="191"
              show-word-limit
            />
          </el-form-item>
          <el-form-item
            data-generator="hinh_anh"
            :label="$t('table.sanpham.hinh_anh')"
            prop="hinh_anh"
            :error="errors.hinh_anh && errors.hinh_anh[0]"
          >
            <el-input
              v-model="form.hinh_anh"
              name="hinh_anh"
              :placeholder="$t('table.sanpham.hinh_anh')"
              maxlength="191"
              show-word-limit
            />
          </el-form-item>
          <el-form-item
            data-generator="so_may"
            :label="$t('table.sanpham.so_may')"
            prop="so_may"
            :error="errors.so_may && errors.so_may[0]"
          >
            <el-input
              v-model="form.so_may"
              name="so_may"
              :placeholder="$t('table.sanpham.so_may')"
              maxlength="191"
              show-word-limit
            />
          </el-form-item>
          <el-form-item
            data-generator="don_vi_tinh"
            :label="$t('table.sanpham.don_vi_tinh')"
            prop="don_vi_tinh"
            :error="errors.don_vi_tinh && errors.don_vi_tinh[0]"
          >
            <el-input
              v-model="form.don_vi_tinh"
              name="don_vi_tinh"
              :placeholder="$t('table.sanpham.don_vi_tinh')"
              maxlength="191"
              show-word-limit
            />
          </el-form-item>
          <el-form-item
            data-generator="tinh_trang_bao_hanh"
            :label="$t('table.sanpham.tinh_trang_bao_hanh')"
            prop="tinh_trang_bao_hanh"
            :error="errors.tinh_trang_bao_hanh && errors.tinh_trang_bao_hanh[0]"
          >
            <el-input
              v-model="form.tinh_trang_bao_hanh"
              name="tinh_trang_bao_hanh"
              :placeholder="$t('table.sanpham.tinh_trang_bao_hanh')"
              maxlength="191"
              show-word-limit
            />
          </el-form-item>
          <el-form-item
            data-generator="ho_so"
            :label="$t('table.sanpham.ho_so')"
            prop="ho_so"
            :error="errors.ho_so && errors.ho_so[0]"
          >
            <el-input
              v-model="form.ho_so"
              name="ho_so"
              :placeholder="$t('table.sanpham.ho_so')"
              maxlength="191"
              show-word-limit
            />
          </el-form-item>
          <el-form-item
            data-generator="ngay_mua"
            :label="$t('table.sanpham.ngay_mua')"
            prop="ngay_mua"
            :error="errors.ngay_mua && errors.ngay_mua[0]"
          >
            <el-date-picker
              v-model="form.ngay_mua"
              name="ngay_mua"
              type="datetime"
              :placeholder="$t('table.sanpham.ngay_mua')"
              value-format="yyyy-MM-dd HH:mm:ss"
            />
          </el-form-item>
          <el-form-item
            data-generator="mo_ta"
            :label="$t('table.sanpham.mo_ta')"
            prop="mo_ta"
            :error="errors.mo_ta && errors.mo_ta[0]"
          >
            <tinymce v-model="form.mo_ta" name="mo_ta" :height="300" />
          </el-form-item>
          <el-form-item
            data-generator="danh_muc_id"
            :label="$t('route.danh_muc')"
            prop="danh_muc_id"
            :error="errors.danh_muc_id && errors.danh_muc_id[0]"
          >
            <el-select
              v-model="form.danh_muc_id"
              name="danh_muc_id"
              filterable
              :placeholder="$t('route.danh_muc')"
              class="tw-w-full"
            >
              <el-option
                v-for="(item, index) in danhMucList"
                :key="'danhMuc_' + index"
                :label="item.ten_danh_muc"
                :value="item.id"
              />
            </el-select>
          </el-form-item>
          <el-form-item
            data-generator="thuong_hieu_id"
            :label="$t('route.thuong_hieu')"
            prop="thuong_hieu_id"
            :error="errors.thuong_hieu_id && errors.thuong_hieu_id[0]"
          >
            <el-select
              v-model="form.thuong_hieu_id"
              name="thuong_hieu_id"
              filterable
              :placeholder="$t('route.thuong_hieu')"
              class="tw-w-full"
            >
              <el-option
                v-for="(item, index) in thuongHieuList"
                :key="'thuongHieu_' + index"
                :label="item.ten_hang"
                :value="item.id"
              />
            </el-select>
          </el-form-item>
          <el-form-item
            data-generator="nhac_cung_cap_id"
            :label="$t('route.nhac_cung_cap')"
            prop="nhac_cung_cap_id"
            :error="errors.nhac_cung_cap_id && errors.nhac_cung_cap_id[0]"
          >
            <el-select
              v-model="form.nhac_cung_cap_id"
              name="nhac_cung_cap_id"
              filterable
              :placeholder="$t('route.nhac_cung_cap')"
              class="tw-w-full"
            >
              <el-option
                v-for="(item, index) in nhacCungCapList"
                :key="'nhacCungCap_' + index"
                :label="item.ten_nhac_cung_cap"
                :value="item.id"
              />
            </el-select>
          </el-form-item>
          <el-form-item
            data-generator="nhap_kho_id"
            :label="$t('route.nhap_kho')"
            prop="nhap_kho_id"
            :error="errors.nhap_kho_id && errors.nhap_kho_id[0]"
          >
            <el-select
              v-model="form.nhap_kho_id"
              name="nhap_kho_id"
              multiple
              filterable
              :placeholder="$t('route.nhap_kho')"
              class="tw-w-full"
            >
              <el-option
                v-for="(item, index) in nhapKhoList"
                :key="'nhapKho_' + index"
                :label="item.ma_phieu_nhap"
                :value="item.id"
              />
            </el-select>
          </el-form-item>
          <!--{{$FROM_ITEM_NOT_DELETE_THIS_LINE$}}-->
          <el-form-item class="tw-flex tw-justify-end">
            <router-link v-slot="{ href, navigate }" :to="{ name: 'Sanpham' }" custom>
              <a :href="href" class="el-button el-button--info is-plain" @click="navigate">{{ $t('button.cancel') }}</a>
            </router-link>
            <template v-if="$route.params.id">
              <el-button :loading="loading.button" type="primary" icon="el-icon-edit" @click="() => update('sanpham')">
                {{ $t('button.update') }}
              </el-button>
            </template>
            <template v-else>
              <el-button :loading="loading.button" type="success" icon="el-icon-plus" @click="() => store('sanpham')">
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
import SanphamResource from '@/api/v1/sanpham';
import Tinymce from '@/components/Tinymce';
import DanhMucResource from '@/api/v1/danh-muc';
import ThuongHieuResource from '@/api/v1/thuong-hieu';
import NhacCungCapResource from '@/api/v1/nhac-cung-cap';
import NhapKhoResource from '@/api/v1/nhap-kho';
// {{$IMPORT_COMPONENT_NOT_DELETE_THIS_LINE$}}

const sanphamResource = new SanphamResource();
const nhapKhoResource = new NhapKhoResource();
const nhacCungCapResource = new NhacCungCapResource();
const thuongHieuResource = new ThuongHieuResource();
const danhMucResource = new DanhMucResource();

export default {
  components: {
    Tinymce,
    // {{$IMPORT_COMPONENT_NAME_NOT_DELETE_THIS_LINE$}}
  },
  mixins: [GlobalForm],
  data() {
    return {
      form: {
        id: '',
        ma_san_pham: '',
        ten_san_pham: '',
        gia_nhap: 0,
        gia_ban: 0,
        ten_khach_ban: '',
        so_dien_thoai_khach_ban: '',
        hinh_anh: '',
        so_may: '',
        don_vi_tinh: '',
        tinh_trang_bao_hanh: '',
        ho_so: '',
        ngay_mua: '',
        mo_ta: '',
        danh_muc_id: '',
        thuong_hieu_id: '',
        nhac_cung_cap_id: '',
        nhap_kho_id: '',
      }, // {{$$}}
      loading: {
        form: false,
        button: false,
      },
      danhMucList: [],
      thuongHieuList: [],
      nhacCungCapList: [],
      nhapKhoList: [],
      // {{$DATA_NOT_DELETE_THIS_LINE$}}
    };
  },
  computed: {
    // not rename rules
    rules() {
      return {
        danh_muc_id: [
          {
            required: true,
            message: this.$t('validation.required', { attribute: this.$t('route.danh_muc') }),
            trigger: ['change'],
          },
        ],
        thuong_hieu_id: [
          {
            required: true,
            message: this.$t('validation.required', { attribute: this.$t('route.thuong_hieu') }),
            trigger: ['change'],
          },
        ],
        nhac_cung_cap_id: [
          {
            required: true,
            message: this.$t('validation.required', { attribute: this.$t('route.nhac_cung_cap') }),
            trigger: ['change'],
          },
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
        data: { data: danhMuc },
      } = await danhMucResource.getDanhMuc();
      this.danhMucList = danhMuc;
      const {
        data: { data: thuongHieu },
      } = await thuongHieuResource.getThuongHieu();
      this.thuongHieuList = thuongHieu;
      const {
        data: { data: nhacCungCap },
      } = await nhacCungCapResource.getNhacCungCap();
      this.nhacCungCapList = nhacCungCap;
      const {
        data: { data: nhapKho },
      } = await nhapKhoResource.getNhapKho();
      this.nhapKhoList = nhapKho;
      // {{$CREATED_NOT_DELETE_THIS_LINE$}}
      if (id) {
        const {
          data: { data: sanpham },
        } = await sanphamResource.get(id);
        this.form = sanpham;
      }
      this.loading.form = false;
    } catch (e) {
      this.loading.form = false;
    }
  },
  methods: {
    store(sanpham) {
      this.$refs[sanpham].validate((valid, errors) => {
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
            await sanphamResource.store(this.form);
            this.$message({
              showClose: true,
              message: this.$t('messages.create'),
              type: 'success',
            });
            this.loading.button = false;
            await this.$router.push({ name: 'Sanpham' });
          } catch (e) {
            this.loading.button = false;
          }
        });
      });
    },
    update(sanpham) {
      this.$refs[sanpham].validate((valid, errors) => {
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
            await sanphamResource.update(this.$route.params.id, this.form);
            this.$message({
              showClose: true,
              message: this.$t('messages.update'),
              type: 'success',
            });
            this.loading.button = false;
            await this.$router.push({ name: 'Sanpham' });
          } catch (e) {
            this.loading.button = false;
          }
        });
      });
    },
  },
};
</script>
