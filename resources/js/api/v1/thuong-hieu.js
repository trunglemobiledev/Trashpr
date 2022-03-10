/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-07 23:38:19
 * File: thuongHieu.js
 */

import Resource from '@/api/resource';
import request from '@/utils/request';

export default class thuongHieuResource extends Resource {
  constructor() {
    super('/thuong-hieus');
  }

  getthuongHieu() {
    return request({
      url: '/thuong-hieus/get-thuong-hieus',
      method: 'get',
    });
  }
  // {{$API_NOT_DELETE_THIS_LINE$}}
}
