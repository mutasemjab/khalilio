{{-- resources/views/user/pdf-bag-category.blade.php --}}
@extends('layouts.front')
@section('title', $category->name . ' - ' . __('messages.card_bag_title'))

@section('content')
    <div class="pb-wrapper">

        <div class="pb-header">
            <a href="{{ route('pdf-bag.index') }}" class="pb-back">{{ __('messages.back') }}</a>
            <div class="pb-icon">{{ $category->icon }}</div>
            <h1 class="pb-title">{{ $category->name }}</h1>
            <p class="pb-subtitle">
                {{ $subcategories->count() }}
                {{ app()->getLocale() === 'ar' ? 'تصنيف فرعي' : 'subcategories' }}
            </p>
        </div>

        @if ($subcategories->count() > 0)
            <div class="pb-categories">
                @foreach ($subcategories as $sub)
                    <a href="{{ route('pdf-bag.subcategory', [$category->id, $sub->id]) }}" class="pb-cat-card">
                        <div class="pb-cat-card__shine"></div>
                        <div class="pb-cat-icon">{{ $sub->icon }}</div>
                        <div class="pb-cat-body">
                            <h3 class="pb-cat-name">{{ $sub->name }}</h3>
                            <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:4px">
                                @if($sub->files_count > 0)
                                <span class="pb-cat-count">
                                    📄 {{ $sub->files_count }}
                                    {{ app()->getLocale() === 'ar' ? 'ملف' : 'files' }}
                                </span>
                                @endif
                                @if($sub->exams_count > 0)
                                <span class="pb-cat-count" style="background:rgba(102,126,234,0.12);color:#667eea">
                                    📝 {{ $sub->exams_count }}
                                    {{ app()->getLocale() === 'ar' ? 'امتحان' : 'exams' }}
                                </span>
                                @endif
                                @if($sub->files_count == 0 && $sub->exams_count == 0)
                                <span class="pb-cat-count" style="background:rgba(0,0,0,0.05);color:#aaa">
                                    {{ app()->getLocale() === 'ar' ? 'فارغ' : 'empty' }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="pb-cat-arrow">
                            {{ app()->getLocale() === 'ar' ? '←' : '→' }}
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="pb-empty">
                <div class="pb-empty-icon">📂</div>
                <h3>{{ app()->getLocale() === 'ar' ? 'لا توجد تصنيفات فرعية بعد' : 'No subcategories yet' }}</h3>
                <a href="{{ route('pdf-bag.index') }}" class="pb-back-btn">
                    {{ app()->getLocale() === 'ar' ? '← العودة' : '→ Back' }}
                </a>
            </div>
        @endif

    </div>

   
    <style>
        .pb-wrapper { max-width: 800px; margin: 0 auto; padding-bottom: 60px; }

        .pb-header { text-align: center; margin-bottom: 32px; animation: pbFadeDown 0.7s ease-out; position: relative; }

        .pb-back {
            position: absolute;
            top: 0;
            right: 0;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #11998e;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            padding: 7px 14px;
            border-radius: 20px;
            background: rgba(17, 153, 142, 0.1);
            transition: all 0.2s ease;
            z-index: 2;
        }
        .pb-back:hover { background: rgba(17,153,142,0.2); color: #11998e; text-decoration: none; }
        html[dir="rtl"] .pb-back { right: auto; left: 0; }

        .pb-icon { font-size: 60px; display: block; margin-bottom: 12px; animation: pbFloat 3s ease-in-out infinite; }

        .pb-title {
            font-size: 30px; font-weight: 800;
            background: linear-gradient(135deg, #11998e, #38ef7d);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
            margin-bottom: 8px;
        }
        .pb-subtitle { color: #666; font-size: 15px; max-width: 500px; margin: 0 auto; line-height: 1.6; }

        /* Categories grid */
        .pb-categories { display: flex; flex-direction: column; gap: 16px; }

        .pb-cat-card {
            display: flex; align-items: center; gap: 18px;
            background: rgba(255,255,255,0.95);
            border: 2px solid rgba(17,153,142,0.15);
            border-radius: 18px; padding: 22px 24px;
            text-decoration: none; color: inherit;
            position: relative; overflow: hidden;
            transition: transform 0.3s cubic-bezier(.34,1.56,.64,1), box-shadow 0.3s ease, border-color 0.3s ease;
            animation: pbCardIn 0.5s ease-out both;
        }
        .pb-cat-card:nth-child(1) { animation-delay: 0.05s; }
        .pb-cat-card:nth-child(2) { animation-delay: 0.10s; }
        .pb-cat-card:nth-child(3) { animation-delay: 0.15s; }
        .pb-cat-card:nth-child(4) { animation-delay: 0.20s; }
        .pb-cat-card:nth-child(5) { animation-delay: 0.25s; }
        .pb-cat-card:nth-child(6) { animation-delay: 0.30s; }

        .pb-cat-card:hover {
            transform: translateY(-4px) scale(1.01);
            box-shadow: 0 16px 40px rgba(17,153,142,0.18);
            border-color: rgba(17,153,142,0.4);
            text-decoration: none; color: inherit;
        }

        .pb-cat-card__shine {
            position: absolute; top: 0; left: -100%; width: 60%; height: 100%;
            background: linear-gradient(105deg, transparent 40%, rgba(56,239,125,0.12) 50%, transparent 60%);
            transition: left 0.5s ease; pointer-events: none;
        }
        .pb-cat-card:hover .pb-cat-card__shine { left: 150%; }

        .pb-cat-icon { font-size: 44px; flex-shrink: 0; filter: drop-shadow(0 3px 6px rgba(17,153,142,0.25)); }

        .pb-cat-body { flex: 1; min-width: 0; }

        .pb-cat-name {
            font-size: 18px; font-weight: 700;
            color: var(--text-color, #2d3748); margin-bottom: 6px;
        }

        .pb-cat-count {
            display: inline-flex; align-items: center; padding: 3px 12px;
            border-radius: 20px; font-size: 13px; font-weight: 600;
            background: rgba(17,153,142,0.1); color: #11998e;
        }

        .pb-cat-arrow {
            flex-shrink: 0; font-size: 22px; font-weight: 700; color: #11998e;
            background: rgba(17,153,142,0.1); width: 44px; height: 44px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 12px; transition: transform 0.3s ease;
        }
        .pb-cat-card:hover .pb-cat-arrow { transform: translateX(-4px); }
        html[dir="ltr"] .pb-cat-card:hover .pb-cat-arrow { transform: translateX(4px); }

        /* Empty */
        .pb-empty { text-align: center; padding: 60px 20px; animation: pbFadeDown 0.6s ease-out; }
        .pb-empty-icon { font-size: 70px; margin-bottom: 16px; display: block; }
        .pb-empty h3 { font-size: 22px; color: var(--text-color, #2d3748); margin-bottom: 8px; }
        .pb-empty p { color: #888; margin-bottom: 20px; font-size: 15px; }
        .pb-wa-btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 12px 26px; background: #25D366; color: white;
            border-radius: 30px; text-decoration: none; font-size: 15px; font-weight: 700;
            transition: all 0.3s ease;
        }
        .pb-wa-btn:hover { color: white; text-decoration: none; transform: translateY(-2px); }

        /* Animations */
        @keyframes pbFadeDown { from { transform: translateY(-24px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        @keyframes pbFloat { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        @keyframes pbCardIn { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

        @media (max-width: 600px) {
            .pb-title { font-size: 24px; }
            .pb-cat-card { padding: 16px; gap: 14px; }
            .pb-cat-name { font-size: 16px; }
        }
    </style>
@endsection