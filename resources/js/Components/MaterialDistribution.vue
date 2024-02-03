<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TailwindTable from '@/Components/TailwindTable.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <div class="grid grid-cols-2 gap-4 my-3">
        <div>
            <InputLabel class="mt-3">Quantidade comprada</InputLabel>
            <TextInput v-model="form.unitOfMeasurement" style="width: 100%"/>

            <InputLabel class="mt-3">Quantidade usada</InputLabel>
            <TextInput v-model="form.unitOfMeasurement" style="width: 100%"/>
        </div>

        <div>
            <InputLabel class="mt-3">Data de compra</InputLabel>
            <TextInput v-model="form.unitOfMeasurement" style="width: 100%"/>

            <InputLabel class="mt-3">Descrição</InputLabel>
            <TextInput v-model="form.unitOfMeasurement" style="width: 100%"/>
        </div>
    </div>
    <div class="text-center">
        <PrimaryButton style="display: block; width: 100%;" class="text-center">Adicionar</PrimaryButton>
    </div>
</template>

<script>
export default {
    data(){
        return {
            tableHeader: [
                {
                    title: 'Nome',
                    name: 'name',
                    minwidth: '300px',
                    maxwidth: '100%',
                    width: '100%'
                },
                {
                    title: 'Quantidade Total',
                    name: 'quantity',
                    minwidth: '160px',
                    maxwidth: '160px',
                    width: '100%'
                },
                {
                    title: 'Última Atualização',
                    name: 'update_at',
                    minwidth: '170px',
                    maxwidth: '170px',
                    width: '100%'
                }
            ],
            tableItems: [],
            showAddModal: false,
            form: {
                name: '',
                unitOfMeasurement: '',
                distribution: {
                    quantity_bought: 0,
                    quantity_used: 0,
                    bought_at: Date.now(),
                    description: '',
                }
            }
        };
    }
}
</script>
