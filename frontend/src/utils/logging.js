import Vue from 'vue';
import store from '@fe/store';
import { isString, isArray } from '@/utils/validate';
import settings from '@fe/settings';

// you can set in settings.js
// errorLog:'production' | ['production', 'development']
const { errorLog: needErrorLog } = settings;

function checkNeed() {
  const env = process.env.NODE_ENV;
  if (isString(needErrorLog)) {
    return env === needErrorLog;
  }
  if (isArray(needErrorLog)) {
    return needErrorLog.includes(env);
  }
  return false;
}
if (checkNeed()) {
  Vue.config.errorHandler = function (err, vm, info) {
    // Don't ask me why I use Vue.nextTick, it just a hack.
    // detail see https://forum.vuejs.org/t/dispatch-in-vue-config-errorhandler-has-some-problem/23500
    Vue.nextTick(() => {
      store.dispatch('app/logging', {
        message: err.message,
        stack: err.stack,
        info,
        screen: window.location.href,
        logging: 1, // frontend
      });
      // eslint-disable-next-line no-console
      console.error(err, info, 'error');
    });
  };
}
