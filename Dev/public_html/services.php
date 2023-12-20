<?php
require(__DIR__."/../partials/nav.php");
?>


<div
  x-data="{
  isVideoPoppedUp: false,
  closeVideo() {
    $refs.video.pause();
    this.isVideoPoppedUp = false;
  },
  openVideo() {
    this.isVideoPoppedUp = true;
    $refs.video.play();
  }
  }"
>
  <section>
    <div
      class="max-w-screen-xl mx-auto px-4 py-28 gap-12 text-gray-600 md:px-8 xl:flex"
    >
      <div class="space-y-5 max-w-2xl mx-auto text-center xl:text-left">
        <div
          class="flex flex-wrap items-center justify-center gap-6 xl:justify-start"
        >
          <div class="flex items-center gap-x-2 text-gray-500 text-sm">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
              class="w-5 h-5"
            >
              <path
                fill-rule="evenodd"
                d="M16.403 12.652a3 3 0 000-5.304 3 3 0 00-3.75-3.751 3 3 0 00-5.305 0 3 3 0 00-3.751 3.75 3 3 0 000 5.305 3 3 0 003.75 3.751 3 3 0 005.305 0 3 3 0 003.751-3.75zm-2.546-4.46a.75.75 0 00-1.214-.883l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                clip-rule="evenodd"
              ></path>
            </svg>
            Trusted
          </div>
          <div class="flex items-center gap-x-2 text-gray-500 text-sm">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
              class="w-5 h-5"
            >
              <path
                fill-rule="evenodd"
                d="M1 4.75C1 3.784 1.784 3 2.75 3h14.5c.966 0 1.75.784 1.75 1.75v10.515a1.75 1.75 0 01-1.75 1.75h-1.5c-.078 0-.155-.005-.23-.015H4.48c-.075.01-.152.015-.23.015h-1.5A1.75 1.75 0 011 15.265V4.75zm16.5 7.385V11.01a.25.25 0 00-.25-.25h-1.5a.25.25 0 00-.25.25v1.125c0 .138.112.25.25.25h1.5a.25.25 0 00.25-.25zm0 2.005a.25.25 0 00-.25-.25h-1.5a.25.25 0 00-.25.25v1.125c0 .108.069.2.165.235h1.585a.25.25 0 00.25-.25v-1.11zm-15 1.11v-1.11a.25.25 0 01.25-.25h1.5a.25.25 0 01.25.25v1.125a.25.25 0 01-.164.235H2.75a.25.25 0 01-.25-.25zm2-4.24v1.125a.25.25 0 01-.25-.25h-1.5a.25.25 0 01-.25.25V11.01a.25.25 0 01.25-.25h1.5a.25.25 0 01.25.25zm13-2.005V7.88a.25.25 0 00-.25-.25h-1.5a.25.25 0 00-.25.25v1.125c0 .138.112.25.25.25h1.5a.25.25 0 00.25-.25zM4.25 7.63a.25.25 0 01.25.25v1.125a.25.25 0 01-.25.25h-1.5a.25.25 0 01-.25-.25V7.88a.25.25 0 01.25-.25h1.5zm0-3.13a.25.25 0 01.25.25v1.125a.25.25 0 01-.25.25h-1.5a.25.25 0 01-.25-.25V4.75a.25.25 0 01.25-.25h1.5zm11.5 1.625a.25.25 0 01-.25-.25V4.75a.25.25 0 01.25-.25h1.5a.25.25 0 01.25.25v1.125a.25.25 0 01-.25.25h-1.5zm-9 3.125a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5z"
                clip-rule="evenodd"
              ></path>
            </svg>
            Over 50+ videos
          </div>
          <div class="flex items-center gap-x-2 text-gray-500 text-sm">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
              class="w-5 h-5"
            >
              <path
                fill-rule="evenodd"
                d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z"
                clip-rule="evenodd"
              ></path>
            </svg>
            400 ratings
          </div>
        </div>
        <h1
          class="text-4xl text-gray-800 font-extrabold mx-auto md:text-5xl"
        >
        Grow your income with free information <span class="text-indigo-600">in real time</span>
        </h1>
        <p class="max-w-xl mx-auto xl:mx-0">
        Join to the journy of becoming rich!
        </p>
        <div
          class="items-center justify-center gap-x-3 space-y-3 sm:flex sm:space-y-0 xl:justify-start"
        >
          <a
            href="./login_register.php"
            class="flex items-center justify-center gap-x-2 py-2 px-4 text-white font-medium bg-gray-800 duration-150 hover:bg-gray-700 active:bg-gray-900 rounded-lg md:inline-flex"
          >
            Start Here
          <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
              class="w-5 h-5"
            >
              <path
                fill-rule="evenodd"
                d="M2 10a.75.75 0 01.75-.75h12.59l-2.1-1.95a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0 11-1.02-1.1l2.1-1.95H2.75A.75.75 0 012 10z"
                clip-rule="evenodd"
              />
            </svg>
          </a>
          <a
            href="./recom.php"
            class="flex items-center justify-center gap-x-2 py-2 px-4 text-gray-700 hover:text-gray-500 font-medium duration-150 active:bg-gray-100 border rounded-lg md:inline-flex"
          >
            Buy it now!
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
              class="w-5 h-5"
            >
              <path
                fill-rule="evenodd"
                d="M2 10a.75.75 0 01.75-.75h12.59l-2.1-1.95a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0 11-1.02-1.1l2.1-1.95H2.75A.75.75 0 012 10z"
                clip-rule="evenodd"
              />
            </svg>
          </a>
        </div>
      </div>

      <div class="flex-1 max-w-xl mx-auto mt-14 xl:mt-0">
        <div class="relative">
          <img
            src="https://images.unsplash.com/photo-1513258496099-48168024aec0?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80"
            class="rounded-lg"
            alt=""
          />
          <button
            class="absolute w-16 h-16 rounded-full inset-0 m-auto duration-150 bg-blue-500 hover:bg-blue-600 ring-offset-2 focus:ring text-white"
            x-on:click="openVideo()"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
              class="w-6 h-6 m-auto"
            >
              <path
                d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"
              />
            </svg>
          </button>
        </div>
      </div>
    </div>
    <div
      x-bind:class="{ 'flex': isVideoPoppedUp, 'hidden': !isVideoPoppedUp }"
      class="fixed inset-0 w-full h-full flex items-center justify-center hidden"
    >
      <div
        class="absolute inset-0 w-full h-full bg-black/50"
        x-on:click="closeVideo()"
      ></div>
      <div class="px-4 relative">
        <button
          class="w-12 h-12 mb-5 rounded-full duration-150 bg-gray-800 hover:bg-gray-700 text-white"
          x-on:click="closeVideo()"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
            class="w-5 h-5 m-auto"
          >
            <path
              d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"
            />
          </svg>
        </button>
        <video x-ref="video" class="rounded-lg w-full max-w-2xl" controls>
          <source
            src="https://raw.githubusercontent.com/sidiDev/remote-assets/main/FloatUI.mp4"
            type="video/mp4"
          />
        </video>
      </div>
    </div>
  </section>
</div>


<section class="relative max-w-screen-xl mx-auto py-4 px-4 md:px-8">
    <div class="absolute top-0 left-0 w-full h-full bg-white opacity-40"></div>
    <div class="relative z-10 gap-5 items-center lg:flex">
        <div class="flex-1 max-w-lg py-5 sm:mx-auto sm:text-center lg:max-w-max lg:text-left">
            <h3 class="text-3xl text-gray-800 font-semibold md:text-4xl">
                Grow your income with free information <span class="text-indigo-600">in real time</span>
            </h3>
            <p class="text-gray-500 leading-relaxed mt-3">
                Join to the journy of becoming rich!
            </p>
            <a class="mt-5 px-4 py-2 text-indigo-600 font-medium bg-indigo-50 rounded-full inline-flex items-center" href="javascript:void()">
                Try it out
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-1 duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>
        <div class="flex-1 mt-5 mx-auto sm:w-9/12 lg:mt-0 lg:w-auto">
            <img src="https://i.postimg.cc/kgd4WhyS/container.png" alt="" class="w-full" />
        </div>
    </div>
</section>

<?php
require(__DIR__ . "/../partials/footer.php");
?>