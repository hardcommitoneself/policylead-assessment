<script setup lang="ts">
type Article = {
    uuid: string;
    title: string;
    link: string;
    date: string;
    excerpt: string;
    image: string;
};

interface Props {
    articles: Article[];
}

const props = defineProps<Props>();
</script>

<template>
    <div class="flex flex-col p-4 gap-10">
        <!-- header -->
        <h1 class="text-2xl font-bold">Artciles</h1>

        <ul class="max-w-7xl mx-auto flex flex-col">
            <li
                class="flex bg-white odd:bg-gray-100 rounded-lg p-4 cursor-pointer"
                v-for="article in articles"
                :key="article.uuid"
            >
                <a :href="article.link" target="_blank">
                    <div class="flex">
                        <!-- left -->
                        <div class="w-8/12 flex flex-col gap-4">
                            <!-- date -->
                            <span>{{ article.date }}</span>

                            <div class="flex flex-col gap-4">
                                <h3 class="truncate text-lg font-bold">
                                    {{ article.title }}
                                </h3>
                                <p>{{ article.excerpt }}</p>
                            </div>
                        </div>

                        <!-- right -->
                        <div class="relative w-4/12 px-4">
                            <img :src="article.image" class="w-full" />
                        </div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</template>
