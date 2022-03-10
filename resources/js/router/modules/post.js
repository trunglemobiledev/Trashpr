/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-10 00:21:11
 * File: Post.js
 */

const post = {
  path: '/posts',
  component: () => import('@/layout'),
  meta: {
    title: 'post',
    icon: 'menu',
    permissions: ['view menu post'],
  },
  children: [
    {
      path: '/posts',
      name: 'Post',
      component: () => import('@/views/post'),
      meta: {
        title: 'post',
        icon: 'list',
        activeMenu: '/posts',
        permissions: ['visit'],
      },
      hidden: true,
    },
    {
      path: 'create',
      name: 'PostCreate',
      hidden: true,
      component: () => import('@/views/post/Form'),
      meta: {
        activeMenu: '/posts',
        title: 'post_create',
        icon: 'record_create',
        permissions: ['create'],
      },
    },
    {
      path: 'edit/:id(\\d+)',
      name: 'PostEdit',
      hidden: true,
      component: () => import('@/views/post/Form'),
      meta: {
        activeMenu: '/posts',
        title: 'post_edit',
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

export default post;
