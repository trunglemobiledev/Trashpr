/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-08 00:15:37
 * File: XuatKho.js
 */

const xuatKho = {
  path: '/xuat-khos',
  component: () => import('@/layout'),
  meta: {
    title: 'xuat_kho',
    icon: 'menu',
    permissions: ['view menu xuat_kho'],
  },
  children: [
    {
      path: '/xuat-khos',
      name: 'XuatKho',
      component: () => import('@/views/xuat-kho'),
      meta: {
        title: 'xuat_kho',
        icon: 'list',
        activeMenu: '/xuat-khos',
        permissions: ['visit'],
      },
      hidden: true,
    },
    {
      path: 'create',
      name: 'XuatKhoCreate',
      hidden: true,
      component: () => import('@/views/xuat-kho/Form'),
      meta: {
        activeMenu: '/xuat-khos',
        title: 'xuat_kho_create',
        icon: 'record_create',
        permissions: ['create'],
      },
    },
    {
      path: 'edit/:id(\\d+)',
      name: 'XuatKhoEdit',
      hidden: true,
      component: () => import('@/views/xuat-kho/Form'),
      meta: {
        activeMenu: '/xuat-khos',
        title: 'xuat_kho_edit',
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

export default xuatKho;
