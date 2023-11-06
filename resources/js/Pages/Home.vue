<script setup>
defineProps({
    laravel: String,
    php: String,
});
</script>

<template>
    <div
        class="bg-slate-900 flex flex-col items-center justify-center min-h-screen"
    >
        <h1
            class="text-slate-200 text-5xl font-semibold mb-4 underline decoration-sky-400"
        >
            Inertia setup with Laravel, Vue and Vite
        </h1>
        <p class="text-slate-400 text-2xl font-semibold">
            Laravel: {{ laravel }}
        </p>
        <p class="text-slate-400 text-2xl font-semibold">PHP: {{ php }}</p>
    </div>
</template>
