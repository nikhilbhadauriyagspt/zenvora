@extends('layouts.admin')

@section('title', 'Admin Dashboard | Zenvora')

@section('content')
<!-- Welcome Title -->
<div class="text-left space-y-1">
    <h1 class="text-2xl font-black text-white tracking-tight">Welcome Back, {{ Auth::user()->username }}!</h1>
    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Compliance Leads & Status Oversight</p>
</div>

<!-- KPI Dashboard Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- KPI 1: Total -->
    <div class="bg-slate-950 border border-slate-800 p-6 rounded-2xl flex items-center justify-between">
        <div class="space-y-1.5 text-left">
            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest block">Total Enquiries</span>
            <span class="text-2xl font-black text-white block">{{ $totalEnquiries }}</span>
        </div>
        <div class="w-10 h-10 rounded-xl bg-slate-900 text-slate-400 flex items-center justify-center text-sm border border-slate-800">
            <i class="fa-solid fa-folder-open"></i>
        </div>
    </div>

    <!-- KPI 2: Pending -->
    <div class="bg-slate-950 border border-slate-800 p-6 rounded-2xl flex items-center justify-between">
        <div class="space-y-1.5 text-left">
            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest block">Pending Reviews</span>
            <span class="text-2xl font-black text-amber-500 block">{{ $pendingEnquiries }}</span>
        </div>
        <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center text-sm border border-amber-500/20">
            <i class="fa-solid fa-clock-rotate-left"></i>
        </div>
    </div>

    <!-- KPI 3: Processed -->
    <div class="bg-slate-950 border border-slate-800 p-6 rounded-2xl flex items-center justify-between">
        <div class="space-y-1.5 text-left">
            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest block">Processed Enquiries</span>
            <span class="text-2xl font-black text-emerald-500 block">{{ $processedEnquiries }}</span>
        </div>
        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-sm border border-emerald-500/20">
            <i class="fa-solid fa-check-double"></i>
        </div>
    </div>
</div>

<!-- Recent Leads Table -->
<div class="bg-slate-950 border border-slate-800 rounded-2xl overflow-hidden p-6">
    <div class="flex items-center justify-between border-b border-slate-800 pb-4 mb-6">
        <div class="text-left">
            <h3 class="text-sm font-black uppercase text-white tracking-widest">Recent Client Leads</h3>
            <p class="text-[10px] text-slate-500 mt-1">Latest incoming customer inquiries</p>
        </div>
        <a href="{{ route('admin.enquiries') }}" class="text-[10px] font-black uppercase tracking-wider text-brand-400 hover:text-brand-350 transition-colors">
            Manage All leads <i class="fa-solid fa-arrow-right ml-1"></i>
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs divide-y divide-slate-900">
            <thead>
                <tr class="text-slate-500 font-extrabold uppercase tracking-wider">
                    <th class="py-3 px-4">Client</th>
                    <th class="py-3 px-4">Contact</th>
                    <th class="py-3 px-4">Service</th>
                    <th class="py-3 px-4">Timeline</th>
                    <th class="py-3 px-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-900/60 font-semibold text-slate-350">
                @forelse($recentEnquiries as $enquiry)
                    <tr>
                        <td class="py-4 px-4 text-left">
                            <span class="text-white block">{{ $enquiry->name }}</span>
                            <span class="text-[10px] text-slate-500">{{ $enquiry->org_size }} Members</span>
                        </td>
                        <td class="py-4 px-4 text-left text-slate-300">
                            <span>{{ $enquiry->phone }}</span>
                            <span class="block text-[10px] text-slate-500">{{ $enquiry->email }}</span>
                        </td>
                        <td class="py-4 px-4 text-left text-brand-400">{{ $enquiry->service }}</td>
                        <td class="py-4 px-4 text-left text-slate-400">{{ $enquiry->timeline }}</td>
                        <td class="py-4 px-4 text-left">
                            <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold 
                                {{ $enquiry->status === 'Pending' ? 'bg-amber-500/10 text-amber-500 border border-amber-500/20' : 'bg-emerald-500/10 text-emerald-500 border border-emerald-500/20' }}">
                                {{ $enquiry->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-slate-500">No incoming enquiries logged yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
