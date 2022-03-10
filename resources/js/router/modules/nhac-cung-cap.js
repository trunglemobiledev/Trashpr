/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-07 23:47:52
 * File: NhacCungCap.js
 */

const nhacCungCap = {
  path: '/nhac-cung-caps',
  component: () => import('@/layout'),
  meta: {
    title: 'nhac_cung_cap',
    icon: 'menu',
    permissions: ['view menu nhac_cung_cap'],
  },
  children: [
    {
      path: '/nhac-cung-caps',
      name: 'NhacCungCap',
      component: () => import('@/views/nhac-cung-cap'),
      meta: {
        title: 'nhac_cung_cap',
        icon: 'list',
        activeMenu: '/nhac-cung-caps',
        permissions: ['visit'],
      },
      hidden: true,
    },
    {
      path: 'create',
      name: 'NhacCungCapCreate',
      hidden: true,
      component: () => import('@/views/nhac-cung-cap/Form'),
      meta: {
        activeMenu: '/nhac-cung-caps',
        title: 'nhac_cung_cap_create',
        icon: 'record_create',
        permissions: ['create'],
      },
    },
    {
      path: 'edit/:id(\\d+)',
      name: 'NhacCungCapEdit',
      hidden: true,
      component: () => import('@/views/nhac-cung-cap/Form'),
      meta: {
        activeMenu: '/nhac-cung-caps',
        title: 'nhac_cung_cap_edit',
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

export default nhacCungCap;
