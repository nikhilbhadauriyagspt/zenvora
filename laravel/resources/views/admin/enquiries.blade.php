@extends('layouts.admin')

@section('title', 'Manage Enquiries | Zenvora')

@section('content')
<div class="flex items-center justify-between">
    <div class="text-left space-y-1">
        <h1 class="text-2xl font-black text-white tracking-tight">Client Enquiries</h1>
        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Review customer lead cards</p>
    </div>
    <a href="{{ route('admin.enquiries.export') }}" class="px-5 py-2.5 rounded-full text-xs font-bold text-slate-900 bg-brand-400 hover:bg-brand-350 transition-all flex items-center gap-1.5 shadow-md shadow-brand-500/5">
        <i class="fa-solid fa-file-csv text-sm"></i> Export CSV
    </a>
</div>

<div class="bg-slate-950 border border-slate-800 rounded-2xl overflow-hidden p-6 mt-6">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs divide-y divide-slate-900">
            <thead>
                <tr class="text-slate-500 font-extrabold uppercase tracking-wider">
                    <th class="py-3 px-4">Client</th>
                    <th class="py-3 px-4">Contact Details</th>
                    <th class="py-3 px-4">Service Required</th>
                    <th class="py-3 px-4">Message Details</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-900/60 font-semibold text-slate-350">
                @forelse($enquiries as $enquiry)
                    <tr id="enquiry-row-{{ $enquiry->id }}">
                        <td class="py-4 px-4 text-left">
                            <span class="text-white block">{{ $enquiry->name }}</span>
                            <span class="text-[10px] text-slate-500">{{ $enquiry->org_size }} Members | {{ $enquiry->timeline }}</span>
                        </td>
                        <td class="py-4 px-4 text-left text-slate-350 font-semibold">
                            <span>{{ $enquiry->phone }}</span>
                            <span class="block text-[10px] text-slate-500">{{ $enquiry->email }}</span>
                        </td>
                        <td class="py-4 px-4 text-left text-brand-400">{{ $enquiry->service }}</td>
                        <td class="py-4 px-4 text-left text-slate-400 max-w-xs truncate" title="{{ $enquiry->message }}">
                            {{ $enquiry->message }}
                        </td>
                        <td class="py-4 px-4 text-left">
                            <span id="badge-status-{{ $enquiry->id }}" class="px-2.5 py-0.5 rounded-full text-[9px] font-bold 
                                {{ $enquiry->status === 'Pending' ? 'bg-amber-500/10 text-amber-500 border border-amber-500/20' : 
                                   ($enquiry->status === 'Processed' ? 'bg-emerald-500/10 text-emerald-500 border border-emerald-500/20' : 
                                    'bg-red-500/10 text-red-500 border border-red-500/20') }}">
                                {{ $enquiry->status }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-left space-x-2">
                            <select onchange="updateStatus({{ $enquiry->id }}, this.value)" class="text-[10px] bg-slate-900 border border-slate-800 rounded px-2 py-1 text-slate-200">
                                <option value="Pending" {{ $enquiry->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Processed" {{ $enquiry->status === 'Processed' ? 'selected' : '' }}>Processed</option>
                                <option value="Canceled" {{ $enquiry->status === 'Canceled' ? 'selected' : '' }}>Canceled</option>
                            </select>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500">No client enquiries logged yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination links -->
    <div class="mt-6 border-t border-slate-900 pt-4">
        {{ $enquiries->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script>
    async function updateStatus(id, newStatus) {
        try {
            const response = await fetch(`/admin/enquiries/${id}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: newStatus })
            });
            const result = await response.json();
            if (result.success) {
                const badge = document.getElementById(`badge-status-${id}`);
                badge.textContent = newStatus;
                badge.className = 'px-2.5 py-0.5 rounded-full text-[9px] font-bold ';
                if (newStatus === 'Pending') {
                    badge.classList.add('bg-amber-500/10', 'text-amber-500', 'border', 'border-amber-500/20');
                } else if (newStatus === 'Processed') {
                    badge.classList.add('bg-emerald-500/10', 'text-emerald-500', 'border', 'border-emerald-500/20');
                } else {
                    badge.classList.add('bg-red-500/10', 'text-red-500', 'border', 'border-red-500/20');
                }
            } else {
                alert('Failed to update status.');
            }
        } catch (err) {
            console.error('Error updating status:', err);
            alert('Error updating status.');
        }
    }
</script>
@endsection
