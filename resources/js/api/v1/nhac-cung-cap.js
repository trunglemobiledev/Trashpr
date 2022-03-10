/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-07 23:47:52
 * File: nhacCungCap.js
 */

import Resource from '@/api/resource';
import request from '@/utils/request';

export default class nhacCungCapResource extends Resource {
  constructor() {
    super('/nhac-cung-caps');
  }

  getnhacCungCap() {
    return request({
      url: '/nhac-cung-caps/get-nhac-cung-caps',
      method: 'get',
    });
  }
  // {{$API_NOT_DELETE_THIS_LINE$}}
}
