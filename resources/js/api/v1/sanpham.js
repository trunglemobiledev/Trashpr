/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-07 23:32:33
 * File: sanpham.js
 */

import Resource from '@/api/resource';
import request from '@/utils/request';

export default class sanphamResource extends Resource {
  constructor() {
    super('/sanphams');
  }

  getsanpham() {
    return request({
      url: '/sanphams/get-sanphams',
      method: 'get',
    });
  }
  // {{$API_NOT_DELETE_THIS_LINE$}}
}
