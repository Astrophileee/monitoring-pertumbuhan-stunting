
import $ from "jquery";
window.$ = window.jQuery = $;

import Alpine from "alpinejs";
window.Alpine = Alpine;
Alpine.start();

// DataTables
import "datatables.net-dt/css/dataTables.dataTables.css";
import DataTable from "datatables.net-dt";

// SweetAlert2
import Swal from "sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
window.Swal = Swal;

// Global Toast Helper
window.showToast = function (type, message) {
    Swal.fire({
        toast: true,
        position: "top-end",
        icon: type,
        title: message,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        background: '#1f2937',
        color: '#f3f4f6'
    });
};

// Global Delete Confirm Helper
window.confirmDelete = function (id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#4b5563',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
        background: '#1f2937',
        color: '#f3f4f6'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteForm' + id).submit();
        }
    })
};

document.addEventListener("DOMContentLoaded", function () {
    const flashMessage = document.getElementById("flash-message");
    if (flashMessage) {
        const type = flashMessage.getAttribute("data-type");
        const message = flashMessage.getAttribute("data-message");
        window.showToast(type, message);
    }
});

$(document).ready(function () {
    const tableOptions = {
        responsive: true,
        pageLength: 10,
        lengthChange: false,
        language: {
            searchPlaceholder: "Cari data...",
            search: "",
            emptyTable: "Tidak ada data yang tersedia",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            zeroRecords: "Pencarian tidak ditemukan",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Next",
                previous: "Prev"
            }
        },
    };

    if ($("#orangTuasTable").length) { $("#orangTuasTable").DataTable(tableOptions); }
    if ($("#balitasTable").length) { $("#balitasTable").DataTable(tableOptions); }
    if ($("#pemeriksaansTable").length) { $("#pemeriksaansTable").DataTable(tableOptions); }
    if ($("#usersTable").length) { $("#usersTable").DataTable(tableOptions); }
    if ($("#laporansTable").length) { $("#laporansTable").DataTable(tableOptions); }
    
    // Custom styling for Tailwind Dark Mode
    setTimeout(() => {
        $('.dataTables_filter input').addClass('bg-gray-800 border border-gray-700 text-gray-200 rounded-lg text-sm ml-2 px-3 py-1.5 focus:border-emerald-500 focus:ring-emerald-500 outline-none');
        $('.dataTables_info, .dataTables_paginate').addClass('text-sm text-gray-400 mt-4');
        $('.paginate_button').addClass('px-3 py-1 border border-gray-700 rounded-md mx-1 hover:bg-gray-700 cursor-pointer');
        $('.paginate_button.current').addClass('bg-emerald-600 border-emerald-600 text-white hover:bg-emerald-500');
    }, 100);
});
