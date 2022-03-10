<template>
  <el-row>
    <el-col :span="24">
      <el-card>
        <div slot="header">
          <template v-if="$route.params.id">
            {{ $t('route.post_edit') }}
          </template>
          <template v-else>
            {{ $t('route.post_create') }}
          </template>
        </div>
        <el-form ref="post" v-loading="loading.form" :model="form" :rules="rules" label-position="top">
          <el-form-item
            data-generator="name"
            :label="$t('table.post.name')"
            prop="name"
            :error="errors.name && errors.name[0]"
          >
            <el-input
              v-model="form.name"
              name="name"
              :placeholder="$t('table.post.name')"
              maxlength="191"
              show-word-limit
            />
          </el-form-item>
          <el-form-item
            data-generator="comment_id"
            :label="$t('route.comment')"
            prop="comment_id"
            :error="errors.comment_id && errors.comment_id[0]"
          >
            <el-select
              v-model="form.comment_id"
              name="comment_id"
              multiple
              filterable
              :placeholder="$t('route.comment')"
              class="tw-w-full"
            >
              <el-option
                v-for="(item, index) in commentList"
                :key="'comment_' + index"
                :label="item.id"
                :value="item.id"
              />
            </el-select>
          </el-form-item>
          <!--{{$FROM_ITEM_NOT_DELETE_THIS_LINE$}}-->
          <el-form-item class="tw-flex tw-justify-end">
            <router-link v-slot="{ href, navigate }" :to="{ name: 'Post' }" custom>
              <a :href="href" class="el-button el-button--info is-plain" @click="navigate">{{ $t('button.cancel') }}</a>
            </router-link>
            <template v-if="$route.params.id">
              <el-button :loading="loading.button" type="primary" icon="el-icon-edit" @click="() => update('post')">
                {{ $t('button.update') }}
              </el-button>
            </template>
            <template v-else>
              <el-button :loading="loading.button" type="success" icon="el-icon-plus" @click="() => store('post')">
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
import PostResource from '@/api/v1/post';
import CommentResource from '@/api/v1/comment';
// {{$IMPORT_COMPONENT_NOT_DELETE_THIS_LINE$}}

const postResource = new PostResource();
const commentResource = new CommentResource();

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
        comment_id: '',
      }, // {{$$}}
      loading: {
        form: false,
        button: false,
      },
      commentList: [],
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
        data: { data: comment },
      } = await commentResource.getComment();
      this.commentList = comment;
      // {{$CREATED_NOT_DELETE_THIS_LINE$}}
      if (id) {
        const {
          data: { data: post },
        } = await postResource.get(id);
        this.form = post;
      }
      this.loading.form = false;
    } catch (e) {
      this.loading.form = false;
    }
  },
  methods: {
    store(post) {
      this.$refs[post].validate((valid, errors) => {
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
            await postResource.store(this.form);
            this.$message({
              showClose: true,
              message: this.$t('messages.create'),
              type: 'success',
            });
            this.loading.button = false;
            await this.$router.push({ name: 'Post' });
          } catch (e) {
            this.loading.button = false;
          }
        });
      });
    },
    update(post) {
      this.$refs[post].validate((valid, errors) => {
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
            await postResource.update(this.$route.params.id, this.form);
            this.$message({
              showClose: true,
              message: this.$t('messages.update'),
              type: 'success',
            });
            this.loading.button = false;
            await this.$router.push({ name: 'Post' });
          } catch (e) {
            this.loading.button = false;
          }
        });
      });
    },
  },
};
</script>
