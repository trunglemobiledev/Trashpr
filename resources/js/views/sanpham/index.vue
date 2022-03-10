<template>
  <el-row>
    <el-col :span="24">
      <el-card>
        <div slot="header" class="tw-flex tw-justify-end tw-items-center">
          <router-link v-slot="{ href, navigate }" v-permission="['create']" :to="{ name: 'SanphamCreate' }" custom>
            <a :href="href" class="pan-btn blue-btn" @click="navigate">
              <i class="el-icon-plus mr-2" />
              {{ $t('button.create') }}
            </a>
          </router-link>
        </div>
        <el-row :gutter="20" type="flex" justify="space-between" class="tw-mb-6 tw-flex-wrap">
          <el-col :xs="24" :sm="12" :md="10" :lg="6">
            <label>{{ $t('table.texts.filter') }}</label>
            <el-input
              v-model="table.listQuery.search"
              class="tw-w-full"
              :placeholder="$t('table.texts.filterPlaceholder')"
            />
          </el-col>
          <el-col :xs="24" :sm="12" :md="10" :lg="10">
            <br />
            <el-date-picker
              v-model="table.listQuery.updated_at"
              class="tw-w-full"
              type="daterange"
              :start-placeholder="$t('date.start_date')"
              :end-placeholder="$t('date.end_date')"
              :picker-options="pickerOptions"
              @change="changeDateRangePicker"
            />
          </el-col>
        </el-row>
        <el-row :gutter="20">
          <el-col :span="24" class="table-responsive">
            <el-table
              v-loading="table.loading"
              class="tw-w-full"
              :data="table.list"
              :default-sort="{ prop: table.listQuery.orderBy, order: table.listQuery.ascending }"
              border
              fit
              highlight-current-row
              @sort-change="sortChange"
            >
              <el-table-column align="center" sortable="custom" prop="id" :label="$t('table.sanpham.id')" width="70px">
                <template slot-scope="{ row }">
                  {{ row.id }}
                </template>
              </el-table-column>
              <el-table-column
                data-generator="ma_san_pham"
                prop="ma_san_pham"
                :label="$t('table.sanpham.ma_san_pham')"
                align="left"
                header-align="center"
              >
                <template slot-scope="{ row }">
                  {{ row.ma_san_pham }}
                </template>
              </el-table-column>
              <el-table-column
                data-generator="ten_san_pham"
                prop="ten_san_pham"
                :label="$t('table.sanpham.ten_san_pham')"
                align="left"
                header-align="center"
              >
                <template slot-scope="{ row }">
                  {{ row.ten_san_pham }}
                </template>
              </el-table-column>
              <el-table-column
                data-generator="gia_nhap"
                prop="gia_nhap"
                :label="$t('table.sanpham.gia_nhap')"
                align="center"
                header-align="center"
              >
                <template slot-scope="{ row }">
                  {{ row.gia_nhap }}
                </template>
              </el-table-column>
              <el-table-column
                data-generator="gia_ban"
                prop="gia_ban"
                :label="$t('table.sanpham.gia_ban')"
                align="center"
                header-align="center"
              >
                <template slot-scope="{ row }">
                  {{ row.gia_ban }}
                </template>
              </el-table-column>
              <el-table-column
                data-generator="ten_khach_ban"
                prop="ten_khach_ban"
                :label="$t('table.sanpham.ten_khach_ban')"
                align="left"
                header-align="center"
              >
                <template slot-scope="{ row }">
                  {{ row.ten_khach_ban }}
                </template>
              </el-table-column>
              <el-table-column
                data-generator="so_dien_thoai_khach_ban"
                prop="so_dien_thoai_khach_ban"
                :label="$t('table.sanpham.so_dien_thoai_khach_ban')"
                align="left"
                header-align="center"
              >
                <template slot-scope="{ row }">
                  {{ row.so_dien_thoai_khach_ban }}
                </template>
              </el-table-column>
              <el-table-column data-generator="hinh_anh" prop="hinh_anh" :label="$t('table.sanpham.hinh_anh')" align="left" header-align="center">
                <template slot-scope="{ row }">
                  {{ row.hinh_anh }}
                </template>
              </el-table-column>
            <el-table-column data-generator="so_may" prop="so_may" :label="$t('table.sanpham.so_may')" align="left" header-align="center">
                <template slot-scope="{ row }">
                  {{ row.so_may }}
                </template>
              </el-table-column>
            <el-table-column data-generator="don_vi_tinh" prop="don_vi_tinh" :label="$t('table.sanpham.don_vi_tinh')" align="left" header-align="center">
                <template slot-scope="{ row }">
                  {{ row.don_vi_tinh }}
                </template>
              </el-table-column>
            <el-table-column data-generator="tinh_trang_bao_hanh" prop="tinh_trang_bao_hanh" :label="$t('table.sanpham.tinh_trang_bao_hanh')" align="left" header-align="center">
                <template slot-scope="{ row }">
                  {{ row.tinh_trang_bao_hanh }}
                </template>
              </el-table-column>
            <el-table-column data-generator="ho_so" prop="ho_so" :label="$t('table.sanpham.ho_so')" align="left" header-align="center">
                <template slot-scope="{ row }">
                  {{ row.ho_so }}
                </template>
              </el-table-column>
            <el-table-column data-generator="ngay_mua" prop="ngay_mua" :label="$t('table.sanpham.ngay_mua')" align="center" header-align="center">
                <template slot-scope="{ row }">
                  {{ row.ngay_mua }}
                </template>
              </el-table-column>
            <el-table-column data-generator="mo_ta" prop="mo_ta" :label="$t('table.sanpham.mo_ta')" align="left" header-align="center">
                <template slot-scope="{ row }">
                  <div v-html="row.mo_ta" />
                </template>
              </el-table-column>
            <el-table-column data-generator="danh_muc_id" prop="danh_muc_id" :label="$t('route.danh_muc')" align="left" header-align="center">
                <template slot-scope="{ row }">
                  {{ row.danh_muc && row.danh_muc.ten_danh_muc }}
                </template>
              </el-table-column>
            <el-table-column data-generator="thuong_hieu_id" prop="thuong_hieu_id" :label="$t('route.thuong_hieu')" align="left" header-align="center">
                <template slot-scope="{ row }">
                  {{ row.thuong_hieu && row.thuong_hieu.ten_hang }}
                </template>
              </el-table-column>
            <el-table-column data-generator="nhac_cung_cap_id" prop="nhac_cung_cap_id" :label="$t('route.nhac_cung_cap')" align="left" header-align="center">
                <template slot-scope="{ row }">
                  {{ row.nhac_cung_cap && row.nhac_cung_cap.ten_nhac_cung_cap }}
                </template>
              </el-table-column>
            <el-table-column data-generator="nhap_kho.ma_phieu_nhap" prop="nhap_kho.ma_phieu_nhap" :label="$t('route.nhap_kho')" align="left" header-align="center">
                  <template slot-scope="{ row }">
                    <template v-for="(item) in row.nhap_khos">
                      <el-tag
                        :key="'nhap_kho.ma_phieu_nhap_' + item.id"
                        class="tw-mr-2"
                        size="medium"
                      >
                        {{ item.ma_phieu_nhap }}
                      </el-tag>
                    </template>
                  </template>
                </el-table-column>
            <!--{{$TEMPLATES_NOT_DELETE_THIS_LINE$}}-->
              <el-table-column
                data-generator="updated_at"
                prop="updated_at"
                :label="$t('date.updated_at')"
                sortable="custom"
                align="center"
                header-align="center"
              >
                <template slot-scope="{ row }">
                  {{ row.updated_at | parseTime('{y}-{m}-{d} {h}:{i}') }}
                </template>
              </el-table-column>
              <el-table-column :label="$t('table.actions')" align="center" class-name="small-padding fixed-width">
                <template slot-scope="{ row }">
                  <router-link
                    v-permission="['edit']"
                    :title="$t('button.edit')"
                    :to="{ name: 'SanphamEdit', params: { id: row.id } }"
                  >
                    <i class="el-icon-edit el-link el-link--primary tw-mr-2" />
                  </router-link>
                  <a
                    v-permission="['delete']"
                    :title="$t('button.delete')"
                    class="cursor-pointer"
                    @click.stop="() => remove(row.id)"
                  >
                    <i class="el-icon-delete el-link el-link--danger" />
                  </a>
                </template>
              </el-table-column>
            </el-table>
            <pagination
              v-if="table.total > 0"
              :total="table.total"
              :page.sync="table.listQuery.page"
              :limit.sync="table.listQuery.limit"
              @pagination="getList"
            />
          </el-col>
        </el-row>
      </el-card>
    </el-col>
  </el-row>
</template>
<script>
import DateRangePicker from '@/plugins/mixins/date-range-picker';
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination
import { debounce } from '@/utils';
import SanphamsResource from '@/api/v1/sanpham';
const sanphamResource = new SanphamsResource();

export default {
  components: { Pagination },
  mixins: [DateRangePicker],
  data() {
    return {
      table: {
        listQuery: {
          search: '',
          limit: 25,
          ascending: 'descending',
          page: 1,
          orderBy: 'updated_at',
          updated_at: [],
        },
        list: null,
        total: 0,
        loading: false,
      },
    };
  },
  watch: {
    'table.listQuery.search': debounce(function () {
      this.handleFilter();
    }, 500),
  },
  created() {
    this.getList();
  },
  methods: {
    async getList() {
      try {
        this.table.loading = true;
        const { data } = await sanphamResource.list(this.table.listQuery);
        this.table.list = data.data;
        this.table.total = data.count;
        this.table.loading = false;
      } catch (e) {
        this.table.loading = false;
      }
    },
    handleFilter() {
      this.table.listQuery.page = 1;
      this.getList();
    },
    changeDateRangePicker(date) {
      if (date) {
        const startDate = this.parseTimeToTz(date[0]);
        const endDate = this.parseTimeToTz(date[1]);
        this.table.listQuery.updated_at = [startDate, endDate];
      } else {
        this.table.listQuery.updated_at = [];
      }
      this.handleFilter();
    },
    sortChange(data) {
      const { prop, order } = data;
      this.table.listQuery.orderBy = prop;
      this.table.listQuery.ascending = order;
      this.getList();
    },
    remove(id) {
      this.$confirm(
        this.$t('messages.delete_confirm', { attribute: this.$t('table.sanpham.id') + '#' + id }),
        this.$t('messages.warning'),
        {
          confirmButtonText: this.$t('button.ok'),
          cancelButtonClass: this.$t('button.cancel'),
          type: 'warning',
          center: true,
        }
      ).then(async () => {
        try {
          this.table.loading = true;
          await sanphamResource.destroy(id);
          const index = this.table.list.findIndex(value => value.id === id);
          this.table.list.splice(index, 1);
          this.$message({
            showClose: true,
            message: this.$t('messages.delete'),
            type: 'success',
          });
          this.table.loading = false;
        } catch (e) {
          this.table.loading = false;
        }
      });
    },
  },
};
</script>
