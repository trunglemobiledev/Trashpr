/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-07 23:41:40
 * File: DanhMuc.js
 */

const danhMuc = {
  path: '/danh-mucs',
  component: () => import('@/layout'),
  meta: {
    title: 'danh_muc',
    icon: 'menu',
    permissions: ['view menu danh_muc'],
  },
  children: [
    {
      path: '/danh-mucs',
      name: 'DanhMuc',
      component: () => import('@/views/danh-muc'),
      meta: {
        title: 'danh_muc',
        icon: 'list',
        activeMenu: '/danh-mucs',
        permissions: ['visit'],
      },
      hidden: true,
    },
    {
      path: 'create',
      name: 'DanhMucCreate',
      hidden: true,
      component: () => import('@/views/danh-muc/Form'),
      meta: {
        activeMenu: '/danh-mucs',
        title: 'danh_muc_create',
        icon: 'record_create',
        permissions: ['create'],
      },
    },
    {
      path: 'edit/:id(\\d+)',
      name: 'DanhMucEdit',
      hidden: true,
      component: () => import('@/views/danh-muc/Form'),
      meta: {
        activeMenu: '/danh-mucs',
        title: 'danh_muc_edit',
        permissions: ['edit'],
        icon: 'edit',
      },
      props: route => {
        return {
          ...route,
          props: true,
        };
      },
    },
  ],
};

export default danhMuc;
