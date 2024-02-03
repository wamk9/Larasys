<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
</script>

<template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Deletar material
                </h2>
                <hr class="my-3" style="border-color: #343e4e;">

                <p class="mt-3">Você está prestes a deletar '{{ item.name }}' e todos os seus lotes, deseja continuar?</p>
                <p class="mt-3">Lembramos que só é possível excluir este material pois o mesmo ainda não foi utilizado em produtos finais.</p>


                <hr class="my-3" style="border-color: #343e4e;">
                <div class="text-right" style="">
                    <PrimaryButton class="mr-2" @click="() => { $emit('update:show', false) }">Cancelar</PrimaryButton>
                    <PrimaryButton class="ml-2" style="background-color: #ff3939;" @click="deleteMaterial">Deletar material</PrimaryButton>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        show: {
            type: Boolean,
            default: false,
        },
        companyId: {
            type: String,
            required: true,
        },
        item: {
            type: Object,
            default: () => {},
        }
    },
    data() {
        return {
            form: {
                id: '',
            },
        };
    },
    methods: {
        updateItem(e, attr) {
            this.form[attr] = e.target.value;
            this.$emit('update:item', this.form);
        },
        updateShow(e) {
            this.$emit('update:show', e.target.value)
        },
        deleteMaterial() {
            const params = {
                id: this.item.id,
                company_id: this.companyId,
            }

            axios.delete(route('api.material.delete'),
            {
                params: params,
                headers: {
                    'Authorization': 'Bearer ' + this.$page.props.auth.token,
                    'Content-Type': 'application/json'
                }
            })
            .then(res => {
                this.$emit('updateDatabase');
                this.$emit('update:show', false)
            })
        },
    }
}
</script>

<style>
@import 'datatables.net-dt';

.dataTables_length,
.dataTables_filter {
    display: none;
}
</style>
