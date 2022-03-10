/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-08 00:00:53
 * File: kho.js
 */

import Resource from '@/api/resource';
import request from '@/utils/request';

export default class khoResource extends Resource {
  constructor() {
    super('/khos');
  }

  getkho() {
    return request({
      url: '/khos/get-khos',
      method: 'get',
    });
  }
  // {{$API_NOT_DELETE_THIS_LINE$}}
}
