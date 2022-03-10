/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-07 23:41:40
 * File: danhMuc.js
 */

import Resource from '@/api/resource';
import request from '@/utils/request';

export default class danhMucResource extends Resource {
  constructor() {
    super('/danh-mucs');
  }

  getdanhMuc() {
    return request({
      url: '/danh-mucs/get-danh-mucs',
      method: 'get',
    });
  }
  // {{$API_NOT_DELETE_THIS_LINE$}}
}
