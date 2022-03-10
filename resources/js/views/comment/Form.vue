<template>
  <el-row>
    <el-col :span="24">
      <el-card>
        <div slot="header">
          <template v-if="$route.params.id">
            {{ $t('route.comment_edit') }}
          </template>
          <template v-else>
            {{ $t('route.comment_create') }}
          </template>
        </div>
        <el-form ref="comment" v-loading="loading.form" :model="form" :rules="rules" label-position="top">
          <el-form-item
            data-generator="name"
            :label="$t('table.comment.name')"
            prop="name"
            :error="errors.name && errors.name[0]"
          >
            <el-input
              v-model="form.name"
              name="name"
              :placeholder="$t('table.comment.name')"
              maxlength="191"
              show-word-limit-f-f
            />
          </el-form-item>
          <el-form-item
            data-generator="post_id"
            :label="$t('route.post')"
            prop="post_id"
            :error="errors.post_id && errors.post_id[0]"
          >
            <el-select
              v-model="form.post_id"
              name="post_id"
              multiple
              filterable
              :placeholder="$t('route.post')"
              class="tw-w-full"
            >
              <el-option v-for="(item, index) in postList" :key="'post_' + index" :label="item.id" :value="item.id" />
            </el-select>
          </el-form-item>
          <!--{{$FROM_ITEM_NOT_DELETE_THIS_LINE$}}-->
          <el-form-item class="tw-flex tw-justify-end">
            <router-link v-slot="{ href, navigate }" :to="{ name: 'Comment' }" custom>
              <a :href="href" class="el-button el-button--info is-plain" @click="navigate">{{ $t('button.cancel') }}</a>
            </router-link>
            <template v-if="$route.params.id">
              <el-button :loading="loading.button" type="primary" icon="el-icon-edit" @click="() => update('comment')">
                {{ $t('button.update') }}
              </el-button>
            </template>
            <template v-else>
              <el-button :loading="loading.button" type="success" icon="el-icon-plus" @click="() => store('comment')">
                {{ $t('button.create') }}
              </el-button>
            </template>
          </el-form-item>
        </el-form>
      </el-card>
    </el-col>
  </el-row>
</template>

<script>
import GlobalForm from '@/plugins/mixins/global-form';
import CommentResource from '@/api/v1/comment';
import PostResource from '@/api/v1/post';
// {{$IMPORT_COMPONENT_NOT_DELETE_THIS_LINE$}}

const commentResource = new CommentResource();
const postResource = new PostResource();

export default {
  components: {
    // {{$IMPORT_COMPONENT_NAME_NOT_DELETE_THIS_LINE$}}
  },
  mixins: [GlobalForm],
  data() {
    return {
      form: {
        id: '',
        name: '',
        post_id: '',
      }, // {{$$}}
      loading: {
        form: false,
        button: false,
      },
      postList: [],
      // {{$DATA_NOT_DELETE_THIS_LINE$}}
    };
  },
  computed: {
    // not rename rules
    rules() {
      return {
        // {{$RULES_NOT_DELETE_THIS_LINE$}}
      };
    },
  },
  async created() {
    try {
      this.loading.form = true;
      const { id } = this.$route.params;
      const {
        data: { data: post },
      } = await postResource.getPost();
      this.postList = post;
      // {{$CREATED_NOT_DELETE_THIS_LINE$}}
      if (id) {
        const {
          data: { data: comment },
        } = await commentResource.get(id);
        this.form = comment;
      }
      this.loading.form = false;
    } catch (e) {
      this.loading.form = false;
    }
  },
  methods: {
    store(comment) {
      this.$refs[comment].validate((valid, errors) => {
        if (this.scrollToError(valid, errors)) {
          return;
        }
        this.$confirm(this.$t('common.popup.create'), {
          confirmButtonText: this.$t('button.create'),
          cancelButtonText: this.$t('button.cancel'),
          type: 'warning',
          center: true,
        }).then(async () => {
          try {
            this.loading.button = true;
            await commentResource.store(this.form);
            this.$message({
              showClose: true,
              message: this.$t('messages.create'),
              type: 'success',
            });
            this.loading.button = false;
            await this.$router.push({ name: 'Comment' });
          } catch (e) {
            this.loading.button = false;
          }
        });
      });
    },
    update(comment) {
      this.$refs[comment].validate((valid, errors) => {
        if (this.scrollToError(valid, errors)) {
          return;
        }
        this.$confirm(this.$t('common.popup.update'), {
          confirmButtonText: this.$t('button.update'),
          cancelButtonText: this.$t('button.cancel'),
          type: 'warning',
          center: true,
        }).then(async () => {
          try {
            this.loading.button = true;
            await commentResource.update(this.$route.params.id, this.form);
            this.$message({
              showClose: true,
              message: this.$t('messages.update'),
              type: 'success',
            });
            this.loading.button = false;
            await this.$router.push({ name: 'Comment' });
          } catch (e) {
            this.loading.button = false;
          }
        });
      });
    },
  },
};
</script>
