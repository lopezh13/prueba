<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Contacto</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- jQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- DevExtreme theme -->
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/23.2.6/css/dx.light.css">
    <!-- Bootstrap JavaScript (popper.js is required for some Bootstrap components) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- DevExtreme libraries -->
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/23.2.6/js/dx.all.js"></script>
    <style>
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .form-container{
            width: 50%;
        } 
        .grid-container {
            width: 100%;
        }
        .center-text {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1 class="center-text mb-4">Formulario de Contacto</h1>
    <div class="container">
        <div class="form-container">
            <div id="formContainer"></div>
        </div>
        <div class="grid-container mt-4">
            <div class="table-title">Contactos Registrados</div>
            <div id="dataGridContainer"></div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Inicializar el formulario DevExtreme
            $("#formContainer").dxForm({
                formData: {},
                items: [
                    {
                        dataField: "tipo_documento",
                        label: { text: "Tipo de Documento" },
                        editorType: "dxSelectBox",
                        editorOptions: {
                            items: ["DUI", "NIT", "Otros", "Pasaporte", "Carnet de Residencia"],
                            value: ""
                        }
                    },
                    {
                        dataField: "numero_documento",
                        label: { text: "Número de Documento" }
                    },
                    {
                        dataField: "nombre",
                        label: { text: "Nombre" }
                    },
                    {
                        dataField: "correo",
                        label: { text: "Correo Electrónico" }
                    },
                    {
                        dataField: "direccion",
                        label: { text: "Dirección Complementaria" }
                    },
                    {
                        itemType: "button",
                        buttonOptions: {
                            text: "Registrar Contacto",
                            elementAttr: { class: "btn btn-primary" },
                            onClick: function(e) {
                                var formData = $("#formContainer").dxForm("instance").option("formData");
                                $.ajax({
                                    url: '<?php echo base_url('index.php/welcome/saveData'); ?>',
                                    type: 'POST',
                                    data: formData,
                                    success: function(response) {
                                        alert('Datos guardados correctamente');
                                        $("#dataGridContainer").dxDataGrid("instance").refresh();
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        console.log(textStatus, errorThrown);
                                    }
                                });
                            }
                        }
                    }
                ]
            });

            // Inicializar el DataGrid DevExtreme
            $("#dataGridContainer").dxDataGrid({
                dataSource: {
                    load: function() {
                        return $.getJSON('<?php echo base_url('index.php/welcome/getData'); ?>');
                    }
                },
                columns: [
                    { dataField: "id", caption: "ID" },
                    { dataField: "tipo_documento", caption: "Tipo de Documento" },
                    { dataField: "numero_documento", caption: "Número de Documento" },
                    { dataField: "nombre", caption: "Nombre" },
                    { dataField: "correo", caption: "Correo Electrónico" },
                    { dataField: "direccion", caption: "Dirección Complementaria" },
                    {
                        dataField: "acciones",
                        caption: "Acciones",
                        cellTemplate: function(container, options) {
                            $('<button>')
                                .addClass('btn btn-warning btn-sm')
                                .text('Editar')
                                .appendTo(container);
                            $('<button>')
                                .addClass('btn btn-danger btn-sm')
                                .text('Eliminar')
                                .appendTo(container);
                        }
                    }
                ],
                paging: {
                    pageSize: 10
                },
                pager: {
                    showPageSizeSelector: true,
                    allowedPageSizes: [10, 20, 50],
                    showInfo: true
                }
            });
        });
    </script>
</body>
</html>
