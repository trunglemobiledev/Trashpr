/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-08 00:00:53
 * File: Kho.js
 */

const kho = {
  path: '/khos',
  component: () => import('@/layout'),
  meta: {
    title: 'kho',
    icon: 'menu',
    permissions: ['view menu kho'],
  },
  children: [
    {
      path: '/khos',
      name: 'Kho',
      component: () => import('@/views/kho'),
      meta: {
        title: 'kho',
        icon: 'list',
        activeMenu: '/khos',
        permissions: ['visit'],
      },
      hidden: true,
    },
    {
      path: 'create',
      name: 'KhoCreate',
      hidden: true,
      component: () => import('@/views/kho/Form'),
      meta: {
        activeMenu: '/khos',
        title: 'kho_create',
        icon: 'record_create',
        permissions: ['create'],
      },
    },
    {
      path: 'edit/:id(\\d+)',
      name: 'KhoEdit',
      hidden: true,
      component: () => import('@/views/kho/Form'),
      meta: {
        activeMenu: '/khos',
        title: 'kho_edit',
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

export default kho;
