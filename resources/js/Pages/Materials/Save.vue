<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
</script>

<template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ modalTitle }}
                </h2>
                <hr class="my-3" style="border-color: #343e4e;">

                <InputLabel class="mt-3">Nome</InputLabel>
                <TextInput v-model="form.name" style="width: 100%"/>

                <InputLabel class="mt-3">Unidade de medida</InputLabel>
                <TextInput v-model="form.unit_of_measurement" style="width: 100%"/>

                <InputLabel class="mt-3">Código de referência</InputLabel>
                <TextInput v-model="form.reference_code" style="width: 100%"/>

                <InputLabel class="mt-3">Descrição do material</InputLabel>
                <TextInput v-model="form.description" style="width: 100%"/>

                <InputLabel class="mt-3">Código de referência</InputLabel>
                <SelectInput v-model="form.material_category_id" :items="materialCategoryItems" style="width: 100%"/>

                <hr class="my-3" style="border-color: #343e4e;">
                <div class="text-right" style="">
                    <PrimaryButton class="mr-2" @click="closeModal(false)">Cancelar</PrimaryButton>
                    <PrimaryButton class="ml-2" @click="saveMaterial">Salvar</PrimaryButton>
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
    data(){
        return {
            showModal: false,
            form: {
                id: '',
                name: '',
                unit_of_measurement: '',
                reference_code: '',
                description: '',
                material_category_id: ''
            },
            materialCategoryItems: []
        };
    },
    methods: {
        closeModal(status) {
            this.$emit('update:show', status)
        },
        fillForm() {
            this.form.id = this.item.id;
            this.form.name = this.item.name;
            this.form.reference_code = this.item.reference_code;
            this.form.unit_of_measurement = this.item.unit_of_measurement;
            this.form.description = this.item.description;
            this.form.material_category_id = this.item.material_category_id;
        },
        saveMaterial() {
            const params = {
                id: this.form.id,
                company_id: this.companyId,
                name: this.form.name,
                unit_of_measurement: this.form.unit_of_measurement,
                reference_code: this.form.reference_code,
                description: this.form.description,
                material_category_id: this.form.material_category_id,
            }
            const url = !!this.form.id ? route('api.material.update') : route('api.material.create');
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
        },
        getMaterialCategories() {
            const params = {
                company_id: 1,
            };

            axios.get(route('api.material-category.list'), {
                params: params,
                headers: {
                    'Authorization': 'Bearer ' + this.$page.props.auth.token,
                    'Content-Type': 'application/json'
                }
            })
            .then(res => {
                this.materialCategoryItems = res.data.message.map((result) => {
                    return {
                        value: result.id,
                        text: result.name,
                    }
                });
            });
        },
    },
    computed: {
        modalTitle(){
            return !!this.form.id ? 'Gerenciar material' : 'Adicionar novo material';
        },
    },
    created() {
        this.getMaterialCategories();
        this.fillForm();
    },
}
</script>
