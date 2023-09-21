<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

export default {
  components: {
    AuthenticatedLayout,
    Head,
  },
  props: {
    response: Object,
  },
  data() {
    return {
      formData: {
        name: this.response?.rt_data?.name ?? '',
        price: this.response?.rt_data?.price ?? '',
        public: this.response?.rt_data?.public ?? '',
        desc: this.response?.rt_data?.desc ?? '',
      }
    };
  },
  methods: {
    submitData() {
      // 驗證
      const { formData, response } = this;
      Swal.fire({
        title: `確認更新: ${ response?.rt_data?.name ?? ''}?`,
        showDenyButton: true,
        confirmButtonText: '更新',
        denyButtonText: `取消`,
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          router.visit(route('product.update'), {
            method: 'put',
            data: { formData, id: response.rt_data.id },
            preserveState: true,
            onSuccess: ({ props }) => {
              if (props.flash.message.rt_code === 1) {
                Swal.fire({
                  title: '更新成功',
                  showDenyButton: true,
                  confirmButtonText: '回列表',
                }).then((result) => {
                  /* Read more about isConfirmed, isDenied below */
                  if (result.isConfirmed) {
                    router.get(route('product.list'));
                  }
                });
              }
            },
          });
        }
      });
    },
    inputClass(item) {
      if (!item) return '';
      return 'border-[red] rounded-[5px]';
    },
    uploadImage(e) {
      const { formData } = this;
      const reader = new FileReader();
      reader.readAsDataURL(e.target.files[0]);
      reader.onload = function () {
        formData.image = reader.result;
      };
      reader.onerror = (error) => {
        console.log('Error: ', error);
      };
    }
  }
};
</script>

<template>
  <Head title="Dashboard" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Product 編輯商品</h2>
      </div>
    </template>
    <section id="product-create" class="px-[15px] py-[10px] rounded-[6px]">
      <form @submit.prevent="submitData()">
        <label for="">
          商品名稱
          <input v-model="formData.name" :class="{ 'border-[red] rounded-[5px]': $page.props.errors['formData.name'] }" type="text">
          <span class="text-[red] ms-2">{{ $page.props?.errors['formData.name'] ?? '' }}</span>
        </label>
        <label>
          商品照片:
          <div class="relative inline-block">
            <div v-if="!formData.image" class="w-[200px] border aspect-[4/3] flex justify-center items-center text-[48px] cursor-pointer">
              +
            </div>
            <img v-else :src="formData.image" class="w-[200px] aspect-[4/3] object-cover" alt="">
            <input class="absolute top-1/2 left-1/2 w-[1px] h-[1px] opacity-0 translate-y-[10px]" name="image" type="file" @change="(e) => uploadImage(e)">
          </div>
        </label>
        <label>
          商品價格
          <input v-model="formData.price" :class="inputClass($page.props?.errors['formData.price'])" type="text">
          <span class="text-[red] ms-2">{{ $page.props?.errors['formData.price'] ?? '' }}</span>
        </label>
        <div class="flex items-center gap-[10px]">公開/非公開
          <label>
            <input v-model="formData.public" type="radio" value="1" required>公開
          </label>
          <label>
            <input v-model="formData.public" type="radio" value="2">不公開
          </label>
        </div>
        <label>
          商品描述
          <input v-model="formData.desc" type="text">
        </label>
        <div class="flex justify-center items-center gap-[45px]">
          <Link :href="route('product.list')" class="btn">取消編輯</Link>
          <button type="submit" class="btn">更新</button>
        </div>
      </form>
    </section>
  </AuthenticatedLayout>
</template>

<style lang="scss" scoped>
#product-create {
  form {
    @apply flex flex-col gap-[10px] bg-white px-[15px] py-[10px];
    .btn {
      @apply border border-[#3c3c3c] bg-[#e3e3e3] font-bold px-[15px] py-[10px] rounded-[5px];
    }
  }
}
</style>
