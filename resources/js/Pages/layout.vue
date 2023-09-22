<script setup>
import { Link, router } from '@inertiajs/vue3';
    function logout(){
        router.post('/logout');
    }
    function getUrl(){
        let url = window.location.pathname;
        return url;
    }
</script>

<template>
     <div class="navbar bg-base-100 shadow-lg ">
            <div class="flex-1">
                <Link v-if="getUrl() != '/login'" as="button" type="button" href="/" class="btn btn-ghost normal-case text-xl">Student List</Link>
            </div>
            <div class="flex-none w-[100px]" v-if="getUrl() == '/'">
                <button @click="logout()" class="btn btn-square btn-ghost w-full h-full p-3">
                Logout
                </button>
            </div>
        </div>
  <main class="min-h-screen min-w-full pt-5">
      <slot />
  </main>
 
</template>