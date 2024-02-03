<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, router } from '@inertiajs/vue3';

const show = defineModel('show', {
    type: Boolean,
    required: true,
});

const item = defineModel('item', {
    type: Object,
    default: () => {},
    required: true,
});


const props = defineProps({
    companyId: {
        type: [String, Number],
        required: true,
    },
    materialId: {
        type: [String, Number],
        required: true,
    },
});
</script>

<template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Adicionar novo lote
                </h2>
                <hr class="my-3" style="border-color: #343e4e;">

                <InputLabel class="mt-3">Quantidade adquirida</InputLabel>
                <TextInput v-model="form.quantity_bought" style="width: 100%"/>

                <InputLabel class="mt-3">Quantidade usada</InputLabel>
                <TextInput v-model="form.quantity_used" style="width: 100%"/>

                <InputLabel class="mt-3">Adquirido em</InputLabel>
                <TextInput v-model="form.bought_at" style="width: 100%"/>

                <InputLabel class="mt-3">Descrição</InputLabel>
                <TextInput v-model="form.price" style="width: 100%"/>

                <InputLabel class="mt-3">Descrição</InputLabel>
                <TextInput v-model="form.description" style="width: 100%"/>

                <hr class="my-3" style="border-color: #343e4e;">
                <div class="text-right" style="">
                    <PrimaryButton class="mr-2" @click="() => { show = false }">Cancelar</PrimaryButton>
                    <PrimaryButton class="ml-2" @click="saveMaterialDistribution">Salvar</PrimaryButton>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                id: '',
                quantity_bought: '',
                quantity_used: '',
                price: '',
                bought_at: new Date(Date.now()).toLocaleDateString(),
                description: '',
            }
        };
    },
    methods: {
        saveMaterialDistribution() {
            const params = {
                id: this.materialId,
                company_id: this.companyId,
                material_id: this.materialId,
                quantity_bought: this.form.quantity_bought,
                quantity_used: this.form.quantity_used,
                price: this.form.price,
                bought_at: this.form.bought_at,
                description: this.form.description,
            }
            const url = !!this.form.id ? route('api.material-distribution.update') : route('api.material-distribution.create');
            const method = !!this.form.id ? 'PUT' : 'POST';

            axios(url,
            {
                method: method,
                data: params,
                headers: {
                    'Authorization': 'Bearer ' + this.$page.props.auth.token,
                    'Content-Type': 'application/json'
                }
            })
            .then(res => {
                this.$emit('updateDatabase');
                this.$emit('update:show', false)
            })
        }
    },
}
</script>
