/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-08 00:10:12
 * File: nhapKho.js
 */

import Resource from '@/api/resource';
import request from '@/utils/request';

export default class nhapKhoResource extends Resource {
  constructor() {
    super('/nhap-khos');
  }

  getnhapKho() {
    return request({
      url: '/nhap-khos/get-nhap-khos',
      method: 'get',
    });
  }
  // {{$API_NOT_DELETE_THIS_LINE$}}
}
