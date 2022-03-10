/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-10 00:23:36
 * File: comment.js
 */

import Resource from '@/api/resource';
import request from '@/utils/request';

export default class commentResource extends Resource {
  constructor() {
    super('/comments');
  }

  getcomment() {
    return request({
      url: '/comments/get-comments',
      method: 'get',
    });
  }
  // {{$API_NOT_DELETE_THIS_LINE$}}
}
