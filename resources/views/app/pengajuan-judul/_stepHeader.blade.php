<div class="d-flex flex-wrap justify-content-between align-items-center text-center mb-8">
    <!-- Step 1 -->
    <div class="d-flex flex-column align-items-center mb-4" style="min-width: 70px;">
        <a href="#">
            <div class="d-flex justify-content-center align-items-center rounded-circle {{ $step == 1 ? 'bg-primary text-white' : 'bg-light-primary text-primary' }}  mb-2"
                style="width: 35px; height: 35px;">
                <span class="fs-6 fw-bold">1</span>
            </div>
        </a>
        <span class="text-gray-600 fw-bold small">Cek Judul </span>
    </div>

    <!-- Line -->
    <div class="flex-grow-1 border-top border-dashed d-none d-sm-block mx-2"></div>

    <!-- Step 2 -->
    <div class="d-flex flex-column align-items-center mb-4" style="min-width: 70px;">
        <a href="#">
            <div class="d-flex justify-content-center align-items-center rounded-circle {{ $step == 2 ? 'bg-primary text-white' : 'bg-light-primary text-primary' }}  mb-2"
                style="width: 35px; height: 35px;">
                <span class="fs-6 fw-bold">2</span>
            </div>
        </a>
        <span class="text-gray-600 fw-bold small">Isi Form</span>
    </div>

    <!-- Line -->
    <div class="flex-grow-1 border-top border-dashed d-none d-sm-block mx-2"></div>

    <!-- Step 3 -->
    <div class="d-flex flex-column align-items-center mb-4" style="min-width: 70px;">
        <a href="#">
            <div class="d-flex justify-content-center align-items-center rounded-circle {{ $step == 3 ? 'bg-primary text-white' : 'bg-light-primary text-primary' }}  mb-2"
                style="width: 35px; height: 35px;">
                <span class="fs-6 fw-bold">3</span>
            </div>
        </a>
        <span class="text-gray-600 fw-bold small">Selesai</span>
    </div>
</div>
