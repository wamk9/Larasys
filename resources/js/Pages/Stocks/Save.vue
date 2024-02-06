<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import SystemMethods from '@/Helpers/General/SystemMethods';
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

                <InputLabel class="mt-3">Código de referência</InputLabel>
                <TextInput v-model="form.reference_code" style="width: 100%"/>

                <InputLabel class="mt-3">Preço sugerido</InputLabel>
                <TextInput v-model="form.price" style="width: 100%"/>

                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mt-6">
                    Equipamentos utilizados
                </h2>
                <hr class="my-3" style="border-color: #343e4e;">

                <div style="display: flex;">
                    <div style="width: 60%;">
                        <InputLabel class="mt-3">Equipamento</InputLabel>
                        <SelectInput v-model="form.equipments" :items="equipmentItems" style="width: 100%"/>
                    </div>
                    <div style="width:35%;" class="mx-2">
                        <InputLabel class="mt-3">Tempo de uso</InputLabel>
                        <TextInput v-model="form.bought_at" style="width: 100%"/>
                    </div>
                    <div style="width:5%;">
                        <PrimaryButton class="mt-9 ml-2" style="float: right;" @click="saveEquipment">+</PrimaryButton>
                    </div>
                </div>

                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mt-6">
                    Materiais utilizados
                </h2>
                <hr class="my-3" style="border-color: #343e4e;">

                <div style="display: flex;">
                    <div style="width: 60%;">
                        <InputLabel class="mt-3">Material</InputLabel>
                        <SelectInput v-model="form.equipments" :items="equipmentItems" style="width: 100%"/>
                    </div>
                    <div style="width:35%;" class="mx-2">
                        <InputLabel class="mt-3">Quantidade</InputLabel>
                        <TextInput v-model="form.bought_at" style="width: 100%"/>
                    </div>
                    <div style="width:5%;">
                        <PrimaryButton class="mt-9 ml-2" style="float: right;" @click="saveEquipment">+</PrimaryButton>
                    </div>
                </div>

                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mt-6">
                    Dados finais
                </h2>
                <hr class="my-3" style="border-color: #343e4e;">

                <div class="grid grid-cols-2 gap-2">
                    <div style="width:100%;">
                        <InputLabel class="mt-3">Cobertura por falhas</InputLabel>
                        <TextInput v-model="fail_value" style="width: 100%" disabled/>
                    </div>
                    <div style="width:100%;">
                        <InputLabel class="mt-3">Preço de venda sugerido</InputLabel>
                        <TextInput v-model="suggest_price" style="width: 100%" disabled/>
                    </div>
                </div>

                <div style="width:100%;">
                    <InputLabel class="mt-3">Preço de venda sugerido</InputLabel>
                    <TextInput v-model="final_price" style="width: 100%" disabled/>
                </div>

                <hr class="my-3" style="border-color: #343e4e;">
                <div class="text-right" style="">
                    <PrimaryButton class="mr-2" @click="closeModal(false)">Cancelar</PrimaryButton>
                    <PrimaryButton class="ml-2" @click="saveEquipment">Salvar</PrimaryButton>
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
                reference_code: '',
                price: '',
                bought_at: new Date(Date.now()).toLocaleDateString(),
                depreciation: '',
                max_date_return_value: new Date(Date.now()).toLocaleDateString(),
                return_value: '',
                use_value: '',
                watts_consume: '',
                equipments: [],
            },
            equipmentItems: [],
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
            this.form.price = this.item.price;
            this.form.bought_at = SystemMethods.dateToDbFormat(this.item.bought_at);
            this.form.depreciation = this.item.depreciation;
            this.form.max_date_return_value = SystemMethods.dateToDbFormat(this.item.max_date_return_value);
            this.form.return_value = this.item.return_value;
            this.form.use_value = this.item.use_value;
            this.form.watts_consume = this.item.watts_consume;
        },
        saveEquipment() {
            const params = {
                id: this.form.id,
                company_id: this.companyId,
                name: this.form.name,
                reference_code: this.form.reference_code,
                price: this.form.price,
                bought_at: this.form.bought_at,
                depreciation: this.form.depreciation,
                max_date_return_value: this.form.max_date_return_value,
                return_value: this.form.return_value,
                use_value: this.form.use_value,
                watts_consume: this.form.watts_consume,
            }
            const url = !!this.form.id ? route('api.equipment.update') : route('api.equipment.create');
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
        getEquipments() {
            const params = {
                company_id: 1,
            };

            axios.get(route('api.equipment.list'), {
                params: params,
                headers: {
                    'Authorization': 'Bearer ' + this.$page.props.auth.token,
                    'Content-Type': 'application/json'
                }
            })
            .then(res => {
                this.equipmentItems = res.data.message.map((result) => {
                    return {
                        value: result.id,
                        text: '(' + result.reference_code + ') ' +  result.name,
                    }
                });
            });
        },
    },
    computed: {
        modalTitle(){
            return !!this.form.id ? 'Gerenciar produto' : 'Adicionar novo produto';
        },
    },
    created() {
        this.getEquipments();
        this.fillForm();
    },
}
</script>
