/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-07 23:32:33
 * File: Sanpham.js
 */

const sanpham = {
  path: '/sanphams',
  component: () => import('@/layout'),
  meta: {
    title: 'sanpham',
    icon: 'menu',
    permissions: ['view menu sanpham'],
  },
  children: [
    {
      path: '/sanphams',
      name: 'Sanpham',
      component: () => import('@/views/sanpham'),
      meta: {
        title: 'sanpham',
        icon: 'list',
        activeMenu: '/sanphams',
        permissions: ['visit'],
      },
      hidden: true,
    },
    {
      path: 'create',
      name: 'SanphamCreate',
      hidden: true,
      component: () => import('@/views/sanpham/Form'),
      meta: {
        activeMenu: '/sanphams',
        title: 'sanpham_create',
        icon: 'record_create',
        permissions: ['create'],
      },
    },
    {
      path: 'edit/:id(\\d+)',
      name: 'SanphamEdit',
      hidden: true,
      component: () => import('@/views/sanpham/Form'),
      meta: {
        activeMenu: '/sanphams',
        title: 'sanpham_edit',
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

export default sanpham;
