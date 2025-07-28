@foreach ($data as $key => $v)
    <tr class="text-start text-gray-600 fs-7">
        <td>
            <span class="fw-semibold">
                {{ ++$i }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                @foreach ($v->pengusuls as $pengusul)
                    {{ $pengusul->nim }} - {{ $pengusul->nama }}{{ !$loop->last ? ', ' : '' }}
                @endforeach
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->judul }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->topik }}
            </span>
        </td>
        <td align="center">
            <span
                class="fw-semibold badge badge-{{ match ($v->status) {
                    'diajukan' => 'warning',
                    'diterima' => 'success',
                    'ditolak' => 'danger',
                    'assigned' => 'info',
                    default => 'secondary',
                } }}">
                {{ $v->status ?? '' }}
            </span>
        </td>
        <td class="d-flex justify-content-center">
            @if ($v->status != 'assigned')
                <a href="#" data-bs-toggle="modal" data-bs-target="#ubahStatusModal{{ $v->id }}"
                    class="me-1">
                    <button type="button" class="btn btn-icon btn-bg-secondary btn-active-color-primary btn-sm">
                        <i class="ki-duotone ki-pencil fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </button>
                </a>
            @endif

            @if ($v->status == 'diterima')
                <button type="button" class="btn btn-icon btn-bg-secondary btn-active-color-primary btn-sm"
                    onclick="showPembimbingModal('{{ $v->id }}', '{{ addslashes($v->judul) }}', '{{ addslashes($v->topik) }}')">
                    <i class="ki-duotone ki-profile-user">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                        <span class="path4"></span>
                       </i>
                    {{-- Ajukan Pembimbing --}}
                </button>
            @endif

            <!-- Modal Ubah Status -->
            <div class="modal fade" id="ubahStatusModal{{ $v->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="{{ route('pengajuan-judul.update-status', $v->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="modal-header">
                                <h5 class="modal-title">Ubah Status Pengajuan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Status Saat Ini:</label>
                                    <span
                                        class="badge bg-{{ match ($v->status) {
                                            'diajukan' => 'warning',
                                            'diterima' => 'success',
                                            'ditolak' => 'danger',
                                            'assigned' => 'info',
                                            default => 'secondary',
                                        } }}">
                                        {{ ucfirst($v->status) }}
                                    </span>
                                </div>

                                <div class="mb-3">
                                    <label for="statusSelect{{ $v->id }}" class="form-label">Pilih Status
                                        Baru</label>
                                    <select class="form-select" data-control="select2" data-hide-search="true"
                                        id="statusSelect{{ $v->id }}" name="status" required>
                                        <option value="diajukan" {{ $v->status == 'diajukan' ? 'selected' : '' }}>
                                            Diajukan</option>
                                        <option value="diterima" {{ $v->status == 'diterima' ? 'selected' : '' }}>
                                            Diterima</option>
                                        <option value="ditolak" {{ $v->status == 'ditolak' ? 'selected' : '' }}>
                                            Ditolak
                                        </option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="catatan{{ $v->id }}" class="form-label">Catatan
                                        (Opsional)</label>
                                    <textarea data-kt-autosize="true" class="form-control" id="catatan{{ $v->id }}" name="catatan" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </td>
    </tr>
@endforeach
