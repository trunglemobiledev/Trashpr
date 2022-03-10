/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-10 00:21:11
 * File: post.js
 */

import Resource from '@/api/resource';
import request from '@/utils/request';

export default class postResource extends Resource {
  constructor() {
    super('/posts');
  }

  getpost() {
    return request({
      url: '/posts/get-posts',
      method: 'get',
    });
  }
  // {{$API_NOT_DELETE_THIS_LINE$}}
}
