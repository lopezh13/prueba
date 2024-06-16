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
        .btn-primary {
           background-color: #007bff;
           border-color: #007bff;
           color: white;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
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
            var formInstance = $("#formContainer").dxForm({
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
                            elementAttr: { class: "btn-primary" },
                            onClick: function(e) {
                                var formData = formInstance.option("formData");
                                if (formData.tipo_documento && formData.numero_documento && formData.nombre && formData.correo && formData.direccion) {
                                    $.ajax({
                                        url: '<?php echo base_url('index.php/welcome/saveData'); ?>',
                                        type: 'POST',
                                        data: formData,
                                        success: function(response) {
                                            alert('Datos guardados correctamente');
                                            $("#dataGridContainer").dxDataGrid("instance").refresh();
                                            formInstance.resetValues();
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            console.log(textStatus, errorThrown);
                                        }
                                    });
                                } else {
                                    alert('Por favor complete todos los campos.');
                                }
                            }
                        }
                    }
                ]
            }).dxForm("instance");

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
                    { dataField: "numero_documento", caption: "N° de Documento" },
                    { dataField: "nombre", caption: "Nombre" },
                    { dataField: "correo", caption: "Correo Electrónico" },
                    { dataField: "direccion", caption: "Dirección" },
                    {
                        dataField: "acciones",
                        caption: "Acciones",
                        cellTemplate: function(container, options) {
                            var editarBtn = $('<button>')
                                .addClass('btn btn-success btn-sm')
                                .text('Editar')
                                .appendTo(container);

                            var borrarBtn = $('<button>')
                                .addClass('btn btn-danger btn-sm ml-1')
                                .text('Borrar')
                                .appendTo(container);

                            editarBtn.on("click", function() {
                                var data = options.data;
                                // Aquí podrías abrir un modal con el formulario prellenado con los datos del contacto para edición
                                console.log("Editar contacto con ID: " + data.id);
                            });

                            borrarBtn.on("click", function() {
                                var data = options.data;
                                if (confirm("¿Estás seguro de que quieres borrar este contacto?")) {
                                    $.ajax({
                                        url: '<?php echo base_url('index.php/welcome/deleteData'); ?>',
                                        type: 'POST',
                                        data: { id: data.id },
                                        success: function(response) {
                                            alert('Contacto borrado correctamente');
                                            $("#dataGridContainer").dxDataGrid("instance").refresh();
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            console.log(textStatus, errorThrown);
                                        }
                                    });
                                }
                            });
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
