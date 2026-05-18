<x-admin-layout 
title="Sobre Nosotros" 
:breadcrumbs="[
    [
        'name' => 'Sobre Nosotros',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'PuppyCare',
    ]
]">

    <div class="max-w-5xl">

        <!-- TARJETA PRINCIPAL -->
        <div class="bg-white rounded-xl shadow-sm p-8 border border-gray-100">

            <!-- ENCABEZADO -->
            <div class="flex items-center gap-4 mb-6">

                <img 
                    src="{{ asset('images/logoveterinaria.jpg') }}"
                    class="w-16 h-16 rounded-full shadow-sm"
                    alt="PuppyCare Logo"
                >

                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        PuppyCare
                    </h1>

                    <p class="text-gray-500">
                        Sistema de gestión veterinaria
                    </p>
                </div>

            </div>

            <!-- CONTENIDO -->
            <div class="space-y-5 text-gray-700 leading-8">

                <p>
                    En <span class="font-semibold text-cyan-600">PuppyCare</span> 
                    nos dedicamos a brindar una gestión eficiente y moderna 
                    para clínicas veterinarias, facilitando el control de citas, 
                    pacientes, historiales médicos y atención especializada para mascotas.
                </p>

                <p>
                    Nuestro objetivo es mejorar la organización y optimizar 
                    la atención veterinaria mediante herramientas digitales 
                    intuitivas, seguras y accesibles.
                </p>

                <p>
                    PuppyCare busca ofrecer una experiencia administrativa 
                    moderna que permita a veterinarios y personal clínico 
                    gestionar información de manera rápida, organizada y confiable.
                </p>

            </div>

        </div>

    </div>

</x-admin-layout>