/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-10 00:23:36
 * File: Comment.js
 */

const comment = {
  path: '/comments',
  component: () => import('@/layout'),
  meta: {
    title: 'comment',
    icon: 'menu',
    permissions: ['view menu comment'],
  },
  children: [
    {
      path: '/comments',
      name: 'Comment',
      component: () => import('@/views/comment'),
      meta: {
        title: 'comment',
        icon: 'list',
        activeMenu: '/comments',
        permissions: ['visit'],
      },
      hidden: true,
    },
    {
      path: 'create',
      name: 'CommentCreate',
      hidden: true,
      component: () => import('@/views/comment/Form'),
      meta: {
        activeMenu: '/comments',
        title: 'comment_create',
        icon: 'record_create',
        permissions: ['create'],
      },
    },
    {
      path: 'edit/:id(\\d+)',
      name: 'CommentEdit',
      hidden: true,
      component: () => import('@/views/comment/Form'),
      meta: {
        activeMenu: '/comments',
        title: 'comment_edit',
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

export default comment;
