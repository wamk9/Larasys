<script setup>
import { createApp } from 'vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TailwindTable from '@/Components/TailwindTable.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import MaterialSave from '@/Pages/Materials/Save.vue'
import MaterialDelete from '@/Pages/Materials/Delete.vue';
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net';
import 'datatables.net-select';
import 'datatables.net-responsive';
import languageBR from 'datatables.net-plugins/i18n/pt-BR.mjs';
import MaterialDistributions from '@/Pages/MaterialDistributions/List.vue';
DataTable.use(DataTablesCore);

</script>

<template>
    <Modal :show="showSaveModal" :closeable="true" @close="closeSaveModal">
        <MaterialSave v-model:show="showSaveModal" v-model:item="materialSelected" :companyId="companyId" @updateDatabase="updateDatabase"/>
    </Modal>

    <Modal :show="showDeleteModal" :closeable="true" @close="closeDeleteModal">
        <MaterialDelete v-model:show="showDeleteModal" :item="materialSelected" :companyId="companyId" @updateDatabase="updateDatabase"/>
    </Modal>

    <Modal :show="showManagementModal" :closeable="true" @close="closeManagementModal">
        <MaterialDistributions v-model:show="showManagementModal" :materialId="materialId" :companyId="companyId" @updateDatabase="updateDatabase"/>
    </Modal>

    <Head title="Materials" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Materiais
                <PrimaryButton style="float: right" @click="openSaveModal('')">Adicionar</PrimaryButton>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <DataTable :options="tableOptions" ref="datatable" :data="tableItems" class="display"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
    data(){
        return {
            tableOptions: {},
            tableItems: [],
            companyId: '1',
            materialId: '',
            tableItems: [],
            showSaveModal: false,
            showDeleteModal: false,
            showManagementModal: false,
            data: {
                id: '',
                name: '',
                unit_of_measurement: '',
                reference_code: '',
                description: ''
            }
        };
    },
    created() {
        const self = this;
        this.tableOptions = {
                language: languageBR,
                order: [[ 0, 'desc' ]],
                aoColumns: [
                    {bSorteable: true},
                    {bSorteable: true},
                    {bSorteable: true},
                    {bSorteable: true},
                    {bSorteable: false},
                ],
                columnDefs: [
                    {
                        targets: [ 0 ],
                        data: 'reference_code',
                        title: 'Referência',
                    },
                    {
                        targets: [ 1 ],
                        data: 'name',
                        title: 'Nome',
                    },
                    {
                        targets: [ 2 ],
                        data: 'remaining_quantity',
                        title: 'Quantidade restante',
                        type: 'num'
                    },
                    {
                        targets: [ 3 ],
                        data: 'updated_at',
                        title: 'Última Atualização',
                        type: 'date',
                        render: (data, type, row, meta) => {
                            return new Date(data).toLocaleString();
                        },
                    },
                    {
                        data: null,
                        defaultContent: '<button class="mr-2">Gerenciar</button>',
                        targets: -1,
                        title: 'Ações',
                        orderable: false,
                        searchable: false,
                        render: function ( data, type, row, meta ) {
                            const fontAwesomeListCheckSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path class="listcheck-icon" d="M152.1 38.2c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 113C-2.3 103.6-2.3 88.4 7 79s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zm0 160c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 273c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zM224 96c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zm0 160c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zM160 416c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H192c-17.7 0-32-14.3-32-32zM48 368a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/></svg>';
                            const fontAwesomePenSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path class="pen-icon" d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>';
                            const fontAwesomeTrashSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path class="trash-icon" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>';

                            return '<button class="btn-edit mx-2">' + fontAwesomePenSvg + '</button>' +
                            '<button class="btn-delete mx-2 '+ (data.can_exclude ? '' : 'disabled') +'" '+ (data.can_exclude ? '' : 'disabled') +'>' + fontAwesomeTrashSvg + '</button>' +
                            '<button class="btn-management mx-2">' + fontAwesomeListCheckSvg + '</button>';
                        },
                        createdCell(td, items, rowData, row, col) {
                            td.addEventListener('click', (e) => {
                                if (e.target.parentNode.classList.contains('btn-edit') || e.target.classList.contains('pen-icon'))
                                    self.openSaveModal(rowData.id);
                                else if (e.target.parentNode.classList.contains('btn-delete') || e.target.classList.contains('trash-icon'))
                                    self.openDeleteModal(rowData.id);
                                else if (e.target.parentNode.classList.contains('btn-management') || e.target.classList.contains('listcheck-icon'))
                                    self.openManagementModal(rowData.id);
                            });
                        }
                    },
                ]
            };

        this.updateDatabase();
    },
    methods:{
        updateDatabase() {
            const params = {
                company_id: 1,
            };

            axios.get(route('api.material.list'), {
                params: params,
                headers: {
                    'Authorization': 'Bearer ' + this.$page.props.auth.token,
                    'Content-Type': 'application/json'
                }
            })
            .then(res => {
                this.tableItems = res.data.message;
            });
        },
        openManagementModal(materialId) {
            this.materialId = materialId;
            this.showManagementModal = true;
        },
        closeManagementModal() {
            this.showManagementModal = false;
        },
        openSaveModal(materialId) {
            if (!materialId) {
                this.data = {
                    quantity_bought: 0,
                    quantity_used: 0,
                    bought_at: new Date(Date.now()).toLocaleDateString(),
                    description: ''
                };
            }

            this.materialId = materialId;
            this.showSaveModal = true;
        },
        closeSaveModal() {
            this.showSaveModal = false;
        },
        openDeleteModal(materialId) {
            this.materialId = materialId;
            this.showDeleteModal = true;
        },
        closeDeleteModal() {
            this.showDeleteModal = false;
        },
    },
    computed: {
        materialSelected() {
            const materialEmpty = {
                id: '',
                name: '',
                unit_of_measurement: '',
                reference_code: '',
                description: ''
            }

            const material = this.tableItems.find((obj) => obj.id == this.materialId );
            return !!material ? material : materialEmpty;
        }
     },
}
</script>

<style>
@import 'datatables.net-dt';

.dataTables_length {
    display: none;
}

.btn-management svg,
.btn-edit svg,
.btn-delete svg {
    height: 17px;
}
.btn-management svg path,
.btn-edit svg path,
.btn-delete svg path {
    fill: #dadada;
}

.btn-delete.disabled svg path {
    fill: grey;
}
</style>
