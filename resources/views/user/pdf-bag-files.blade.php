{{-- resources/views/user/pdf-bag-files.blade.php — Files in a category --}}
@extends('layouts.front')

@section('title', $category->name . ' - ' . __('messages.card_bag_title'))

@section('content')
    <div class="pb-wrapper">

        <div class="pb-header">
            <a href="{{ route('pdf-bag.category', $category->id) }}" class="ts-back">{{ __('messages.back') }}</a>
            <div class="pb-icon">{{ $category->icon }}</div>
            <h1 class="pb-title">{{ $category->name }}</h1>
            <p class="pb-subtitle">
                {{ $files->count() }}
                {{ app()->getLocale() === 'ar' ? 'ملف متاح في هذا التصنيف' : 'files available in this category' }}
            </p>
        </div>

        @if ($files->count() > 0)
            <div class="pb-grid">
                @foreach ($files as $file)
                    <a href="{{ $file->url }}" target="_blank" class="pb-card">
                        <div class="pb-card__shine"></div>
                        <div class="pb-card__left">
                            <div class="pb-card__pdf-icon">📄</div>
                        </div>
                        <div class="pb-card__body">
                            <h3 class="pb-card__name">{{ $file->title }}</h3>
                            <div class="pb-card__meta">
                                <span class="pb-badge">{{ $file->size }}</span>
                                <span class="pb-badge pb-badge--date">{{ $file->created_at->format('Y-m-d') }}</span>
                            </div>
                        </div>
                        <div class="pb-card__download">
                            <span class="pb-dl-icon">⬇</span>
                            <span class="pb-dl-label">{{ app()->getLocale() === 'ar' ? 'تحميل' : 'Download' }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="pb-empty">
                <div class="pb-empty-icon">📂</div>
                <h3>{{ app()->getLocale() === 'ar' ? 'لا توجد ملفات في هذا التصنيف بعد' : 'No files in this category yet' }}</h3>
                <p>{{ app()->getLocale() === 'ar' ? 'سيتم إضافة ملفات قريباً.' : 'Files will be added soon.' }}</p>
                <a href="{{ route('pdf-bag.index') }}" class="pb-back-btn">
                    {{ app()->getLocale() === 'ar' ? '← العودة للتصنيفات' : '→ Back to Categories' }}
                </a>
            </div>
        @endif

    </div>

    <style>
        .pb-wrapper { max-width: 800px; margin: 0 auto; padding-bottom: 60px; }

        .pb-header { text-align: center; margin-bottom: 32px; animation: pbFadeDown 0.7s ease-out; position: relative; }

        .pb-icon { font-size: 60px; display: block; margin-bottom: 12px; animation: pbFloat 3s ease-in-out infinite; }

        .pb-title {
            font-size: 30px; font-weight: 800;
            background: linear-gradient(135deg, #11998e, #38ef7d);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
            margin-bottom: 8px;
        }
        .pb-subtitle { color: #666; font-size: 15px; max-width: 500px; margin: 0 auto; line-height: 1.6; }

        /* Grid */
        .pb-grid { display: flex; flex-direction: column; gap: 16px; }

        .pb-card {
            display: flex; align-items: center; gap: 18px;
            background: rgba(255,255,255,0.95);
            border: 2px solid rgba(17,153,142,0.15);
            border-radius: 18px; padding: 20px 24px;
            text-decoration: none; color: inherit;
            position: relative; overflow: hidden;
            transition: transform 0.3s cubic-bezier(.34,1.56,.64,1), box-shadow 0.3s ease, border-color 0.3s ease;
            animation: pbCardIn 0.5s ease-out both;
        }
        .pb-card:nth-child(1) { animation-delay: 0.05s; }
        .pb-card:nth-child(2) { animation-delay: 0.10s; }
        .pb-card:nth-child(3) { animation-delay: 0.15s; }
        .pb-card:nth-child(4) { animation-delay: 0.20s; }
        .pb-card:nth-child(5) { animation-delay: 0.25s; }

        .pb-card:hover {
            transform: translateY(-4px) scale(1.01);
            box-shadow: 0 16px 40px rgba(17,153,142,0.18);
            border-color: rgba(17,153,142,0.4);
            text-decoration: none; color: inherit;
        }

        .pb-card__shine {
            position: absolute; top: 0; left: -100%; width: 60%; height: 100%;
            background: linear-gradient(105deg, transparent 40%, rgba(56,239,125,0.12) 50%, transparent 60%);
            transition: left 0.5s ease; pointer-events: none;
        }
        .pb-card:hover .pb-card__shine { left: 150%; }

        .pb-card__left { flex-shrink: 0; }
        .pb-card__pdf-icon { font-size: 42px; filter: drop-shadow(0 3px 6px rgba(17,153,142,0.25)); }
        .pb-card__body { flex: 1; min-width: 0; }
        .pb-card__name {
            font-size: 17px; font-weight: 700;
            color: var(--text-color, #2d3748); margin-bottom: 8px;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .pb-card__meta { display: flex; gap: 8px; flex-wrap: wrap; }
        .pb-badge {
            display: inline-flex; align-items: center; padding: 3px 10px;
            border-radius: 20px; font-size: 12px; font-weight: 600;
            background: rgba(17,153,142,0.1); color: #11998e;
        }
        .pb-badge--date { background: rgba(100,100,100,0.08); color: #888; }

        .pb-card__download {
            flex-shrink: 0; display: flex; flex-direction: column; align-items: center; gap: 4px;
            background: linear-gradient(135deg, #11998e, #38ef7d); color: white;
            padding: 12px 18px; border-radius: 14px; font-weight: 700;
            transition: transform 0.25s ease;
        }
        .pb-card:hover .pb-card__download { transform: scale(1.08); }
        .pb-dl-icon { font-size: 20px; }
        .pb-dl-label { font-size: 12px; }

        /* Empty */
        .pb-empty { text-align: center; padding: 60px 20px; animation: pbFadeDown 0.6s ease-out; }
        .pb-empty-icon { font-size: 70px; margin-bottom: 16px; display: block; }
        .pb-empty h3 { font-size: 20px; color: var(--text-color, #2d3748); margin-bottom: 8px; }
        .pb-empty p { color: #888; margin-bottom: 20px; font-size: 15px; }
        .pb-back-btn {
            display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px;
            background: linear-gradient(135deg, #11998e, #38ef7d); color: white;
            border-radius: 30px; text-decoration: none; font-size: 15px; font-weight: 700;
            transition: all 0.3s ease;
        }
        .pb-back-btn:hover { color: white; text-decoration: none; transform: translateY(-2px); }

        /* Animations */
        @keyframes pbFadeDown { from { transform: translateY(-24px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        @keyframes pbFloat { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        @keyframes pbCardIn { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

        @media (max-width: 600px) {
            .pb-title { font-size: 24px; }
            .pb-card { padding: 16px; gap: 14px; }
            .pb-card__name { font-size: 15px; }
            .pb-card__download { padding: 10px 12px; }
        }
    </style>
@endsection
