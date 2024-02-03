<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    headers: {
        type: Array,
        required: true,
    },
    items: {
        type: Array,
        default: () => []
    },
});

const classes = computed(() =>
    props.active
        ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 dark:border-indigo-600 text-sm font-medium leading-5 text-gray-900 dark:text-gray-100 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
        : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out'
);

const headerStyles = (header) => {
    return {
        'min-width': header.minwidth,
        'max-width': header.maxwidth,
        width: header.width
    };
};

</script>

<template>
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <table class="min-w-full text-left text-sm font-light">
                <thead class="border-b font-medium dark:border-neutral-500">
                    <tr>
                    <th v-for="header in headers" scope="col" class="px-6 py-4" :style="headerStyles(header)">{{ header.title }}</th>
                    <th scope="col" class="px-6 py-4 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in items" class="border-b dark:border-neutral-500">
                        <td v-for="header in headers" class="whitespace-nowrap px-6 py-4">{{ item[header.name] }}</td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium text-right"><a href="#">Editar</a> <a href="#">Excluir</a></td>
                    </tr>
                </tbody>
                </table>
            </div>
            </div>
        </div>
        </div>
</template>
