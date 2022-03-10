/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-08 00:10:12
 * File: NhapKho.js
 */

const nhapKho = {
  path: '/nhap-khos',
  component: () => import('@/layout'),
  meta: {
    title: 'nhap_kho',
    icon: 'menu',
    permissions: ['view menu nhap_kho'],
  },
  children: [
    {
      path: '/nhap-khos',
      name: 'NhapKho',
      component: () => import('@/views/nhap-kho'),
      meta: {
        title: 'nhap_kho',
        icon: 'list',
        activeMenu: '/nhap-khos',
        permissions: ['visit'],
      },
      hidden: true,
    },
    {
      path: 'create',
      name: 'NhapKhoCreate',
      hidden: true,
      component: () => import('@/views/nhap-kho/Form'),
      meta: {
        activeMenu: '/nhap-khos',
        title: 'nhap_kho_create',
        icon: 'record_create',
        permissions: ['create'],
      },
    },
    {
      path: 'edit/:id(\\d+)',
      name: 'NhapKhoEdit',
      hidden: true,
      component: () => import('@/views/nhap-kho/Form'),
      meta: {
        activeMenu: '/nhap-khos',
        title: 'nhap_kho_edit',
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

export default nhapKho;
