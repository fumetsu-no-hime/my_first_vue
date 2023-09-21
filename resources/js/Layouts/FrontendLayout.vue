<script>
import { router } from '@inertiajs/vue3';

export default {
  methods: {
    logout() {
      router.post(route('logout'));
    },
  }
};
</script>

<template>
  <section id="frontend-layout">
    <header id="header">
      <div v-if="!$page.props.auth.user" class="flex justify-end items-center gap-5">
        <Link :href="route('register')" class="btn-base">註冊</Link>
        <Link :href="route('dashboard')" class="btn-base">登入</Link>
      </div>
      <div v-else class="flex justify-end items-center gap-5">
        <Link :href="route('product.shopping_cart')" class="btn-base">購物車</Link>
        <button type="button" class="btn-base" @click="logout()">登出</button>
      </div>
    </header>
    <main id="main">
      <slot />
    </main>
    <footer id="footer"></footer>
  </section>
</template>

<style lang="scss" scoped>
#frontend-layout {
    @apply w-full min-h-screen;
}

#main {
    @apply min-h-[calc(100dvh-42px)];
}

#header,
#footer {
    @apply bg-[#00bd89] p-3;
}

.btn-base {
     @apply p-1.5 border-2 rounded-md border-[#656565] bg-[#dfdfdf] cursor-pointer;
}
</style>
