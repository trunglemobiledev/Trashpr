/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-07 23:38:19
 * File: ThuongHieu.js
 */

const thuongHieu = {
  path: '/thuong-hieus',
  component: () => import('@/layout'),
  meta: {
    title: 'thuong_hieu',
    icon: 'menu',
    permissions: ['view menu thuong_hieu'],
  },
  children: [
    {
      path: '/thuong-hieus',
      name: 'ThuongHieu',
      component: () => import('@/views/thuong-hieu'),
      meta: {
        title: 'thuong_hieu',
        icon: 'list',
        activeMenu: '/thuong-hieus',
        permissions: ['visit'],
      },
      hidden: true,
    },
    {
      path: 'create',
      name: 'ThuongHieuCreate',
      hidden: true,
      component: () => import('@/views/thuong-hieu/Form'),
      meta: {
        activeMenu: '/thuong-hieus',
        title: 'thuong_hieu_create',
        icon: 'record_create',
        permissions: ['create'],
      },
    },
    {
      path: 'edit/:id(\\d+)',
      name: 'ThuongHieuEdit',
      hidden: true,
      component: () => import('@/views/thuong-hieu/Form'),
      meta: {
        activeMenu: '/thuong-hieus',
        title: 'thuong_hieu_edit',
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

export default thuongHieu;
