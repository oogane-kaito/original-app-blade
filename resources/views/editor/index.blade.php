@php
$themes = [
    ['id' => 'nature', 'name' => 'しぜん', 'bg' => '#f0fdf4', 'accent' => '#22c55e', 'icon' => '🌿'],
    ['id' => 'sunny', 'name' => 'たいよう', 'bg' => '#fff7ed', 'accent' => '#f97316', 'icon' => '☀️'],
    ['id' => 'warm', 'name' => 'あたたか', 'bg' => '#fef3c7', 'accent' => '#f59e0b', 'icon' => '🌻'],
    ['id' => 'fresh', 'name' => 'さわやか', 'bg' => '#f0f9ff', 'accent' => '#0ea5e9', 'icon' => '💧'],
    ['id' => 'gentle', 'name' => 'やさしい', 'bg' => '#fdf4ff', 'accent' => '#d946ef', 'icon' => '🦋'],
];

$cardData = $businessCard ?? [
    'id' => null,
    'name' => '',
    'title' => '',
    'bio' => '',
    'avatar' => '/placeholder.svg?height=120&width=120',
    'theme' => 'nature',
    'backgroundColor' => '#f0fdf4',
    'textColor' => '#1f2937',
    'accentColor' => '#22c55e',
    'phone' => '',
    'email' => '',
    'links' => [],
    'visibility' => false
];

// linksが配列でない場合の対処
if (!is_array($cardData['links'])) {
    $cardData['links'] = [];
}
@endphp

@extends('layouts.app')

@section('content')
    <div 
        class="min-h-screen bg-gradient-to-br from-orange-50 via-green-50 to-white"
        x-data="editorData()"
        x-init="initEditor()"
    >
        <!-- Header -->
        <header class="border-b bg-white/80 backdrop-blur-sm sticky top-0 z-50">
            <div class="container mx-auto px-4 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('dashboard') }}">
                            <x-ui.button variant="ghost" size="sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                                戻る
                            </x-ui.button>
                        </a>
                        <div class="flex items-center gap-2">
                            <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span class="text-lg font-bold text-gray-800">名刺エディター(デモ)</span>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <x-ui.button type="submit" form="business-card-form" size="lg">
                            保存
                        </x-ui.button>
                        <x-ui.button @click="toggleVisibilityAndSubmit()" size="lg">
                            <span x-text="cardData.visibility ? '非公開にして保存' : '公開して保存'"></span>
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </header>

        <!-- メインフォーム -->
        <form 
            id="business-card-form" 
            method="POST" 
            action="{{ $cardData['id'] ? route('business-cards.update', $cardData['id']) : route('business-cards.store') }}"
            x-ref="mainForm"
        >
            @csrf
            @if($cardData['id'])
                @method('PUT')
            @endif

            <!-- 隠しフィールド -->
            <input type="hidden" name="theme" x-model="cardData.theme">
            <input type="hidden" name="backgroundColor" x-model="cardData.backgroundColor">
            <input type="hidden" name="textColor" x-model="cardData.textColor">
            <input type="hidden" name="accentColor" x-model="cardData.accentColor">
            <input type="hidden" name="avatar" x-model="cardData.avatar">
            <input type="hidden" name="visibility" x-model="cardData.visibility">
            <input type="hidden" name="links" x-model="JSON.stringify(getVisibleLinks())">

            <div class="container mx-auto px-4 py-8">
                <div class="grid lg:grid-cols-2 gap-8">
                    <!-- Editor Panel -->
                    <div class="space-y-6">
                        @if($errors->any())
                            <x-ui.alert variant="destructive">
                                <x-ui.alert-title>エラーが発生しました</x-ui.alert-title>
                                <x-ui.alert-description>
                                    <ul class="list-disc list-inside">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </x-ui.alert-description>
                            </x-ui.alert>
                        @endif

                        @if(session('success'))
                            <x-ui.alert>
                                <x-ui.alert-title>成功</x-ui.alert-title>
                                <x-ui.alert-description>
                                    {{ session('success') }}
                                </x-ui.alert-description>
                            </x-ui.alert>
                        @endif

                        <x-ui.tabs defaultValue="basic">
                            <x-ui.tabs-list class="grid w-full grid-cols-3 bg-white rounded-2xl p-1 shadow-sm">
                                <x-ui.tabs-trigger value="basic" class="flex items-center gap-2 rounded-xl">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    基本情報
                                </x-ui.tabs-trigger>
                                <x-ui.tabs-trigger value="design" class="flex items-center gap-2 rounded-xl">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z" />
                                    </svg>
                                    デザイン
                                </x-ui.tabs-trigger>
                                <x-ui.tabs-trigger value="links" class="flex items-center gap-2 rounded-xl">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                    </svg>
                                    リンク
                                </x-ui.tabs-trigger>
                            </x-ui.tabs-list>

                            <!-- 基本情報タブ -->
                            <x-ui.tabs-content value="basic" class="space-y-4">
                                <x-ui.card class="border-0 shadow-lg bg-white rounded-2xl">
                                    <x-ui.card-header>
                                        <x-ui.card-title class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            基本情報
                                        </x-ui.card-title>
                                    </x-ui.card-header>
                                    <x-ui.card-content class="space-y-4">
                                        <div class="space-y-2">
                                            <x-ui.label for="name">お名前 <span class="text-red-500">*</span></x-ui.label>
                                            <x-ui.input
                                                id="name"
                                                name="name"
                                                x-model="cardData.name"
                                                placeholder="お名前を入力してください"
                                                class="rounded-xl"
                                                value="{{ old('name', $cardData['name']) }}"
                                                required
                                            />
                                            @error('name')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="space-y-2">
                                            <x-ui.label for="title">肩書き・職業</x-ui.label>
                                            <x-ui.input
                                                id="title"
                                                name="title"
                                                x-model="cardData.title"
                                                placeholder="肩書き・職業を入力してください"
                                                class="rounded-xl"
                                                value="{{ old('title', $cardData['title']) }}"
                                            />
                                            @error('title')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="space-y-2">
                                            <x-ui.label for="email">メールアドレス</x-ui.label>
                                            <x-ui.input
                                                id="email"
                                                name="email"
                                                x-model="cardData.email"
                                                placeholder="メールアドレスを入力してください"
                                                class="rounded-xl"
                                                type="email"
                                                value="{{ old('email', $cardData['email']) }}"
                                            />
                                            @error('email')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="space-y-2">
                                            <x-ui.label for="phone">電話番号</x-ui.label>
                                            <x-ui.input
                                                id="phone"
                                                name="phone"
                                                x-model="cardData.phone"
                                                placeholder="電話番号を入力してください"
                                                class="rounded-xl"
                                                value="{{ old('phone', $cardData['phone']) }}"
                                            />
                                            @error('phone')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="space-y-2">
                                            <x-ui.label for="bio">自己紹介</x-ui.label>
                                            <x-ui.textarea
                                                id="bio"
                                                name="bio"
                                                x-model="cardData.bio"
                                                placeholder="あなたの魅力を伝える自己紹介文を書いてください"
                                                rows="4"
                                                class="rounded-xl"
                                            >{{ old('bio', $cardData['bio']) }}</x-ui.textarea>
                                            @error('bio')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </x-ui.card-content>
                                </x-ui.card>
                            </x-ui.tabs-content>

                            <!-- デザインタブ -->
                            <x-ui.tabs-content value="design" class="space-y-4">
                                <x-ui.card class="border-0 shadow-lg bg-white rounded-2xl">
                                    <x-ui.card-header>
                                        <x-ui.card-title class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z" />
                                            </svg>
                                            テーマ選択
                                        </x-ui.card-title>
                                    </x-ui.card-header>
                                    <x-ui.card-content>
                                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                            <template x-for="theme in themes" :key="theme.id">
                                                <button
                                                    type="button"
                                                    @click="updateTheme(theme.id)"
                                                    class="p-4 rounded-2xl border-2 transition-all"
                                                    :class="cardData.theme === theme.id ? 'border-orange-400 shadow-lg scale-105' : 'border-gray-200 hover:border-gray-300'"
                                                    :style="`background-color: ${theme.bg}`"
                                                >
                                                    <div class="text-2xl mb-2" x-text="theme.icon"></div>
                                                    <div class="w-full h-6 rounded-lg mb-2" :style="`background-color: ${theme.accent}`"></div>
                                                    <span class="text-sm font-medium" x-text="theme.name"></span>
                                                </button>
                                            </template>
                                        </div>
                                    </x-ui.card-content>
                                </x-ui.card>
                            </x-ui.tabs-content>

                            <!-- リンクタブ -->
                            <x-ui.tabs-content value="links" class="space-y-4">
                                <x-ui.card class="border-0 shadow-lg bg-white rounded-2xl">
                                    <x-ui.card-header>
                                        <div class="flex items-center justify-between">
                                            <x-ui.card-title class="flex items-center gap-2">
                                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                </svg>
                                                リンク管理
                                            </x-ui.card-title>
                                            <x-ui.button type="button" @click="addLink()" size="sm" variant="outline" class="rounded-full">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                                追加
                                            </x-ui.button>
                                        </div>
                                    </x-ui.card-header>
                                    <x-ui.card-content class="space-y-4">
                                        <template x-for="(item, index) in getVisibleLinks()" :key="item.id">
                                            <div class="p-4 border rounded-2xl space-y-3 bg-gradient-to-r from-orange-50 to-green-50">
                                                <div class="flex items-center justify-between">
                                                    <x-ui.badge variant="secondary" class="rounded-full" x-text="item.icon"></x-ui.badge>
                                                    <x-ui.button
                                                        type="button"
                                                        @click="removeLink(item.id)"
                                                        size="sm"
                                                        variant="ghost"
                                                        class="text-red-500 hover:text-red-700 rounded-full"
                                                    >
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </x-ui.button>
                                                </div>
                                                <div class="space-y-2">
                                                    <div x-show="item.icon === 'website'">
                                                        <x-ui.input
                                                            x-model="item.title"
                                                            placeholder="URLの名前を付けてください"
                                                            class="rounded-xl"
                                                        />
                                                    </div>
                                                    <x-ui.input
                                                        x-model="item.url"
                                                        placeholder="URLを入力してください"
                                                        class="rounded-xl"
                                                        type="url"
                                                    />
                                                    <select 
                                                        x-model="item.icon" 
                                                        @change="updateLinkIcon(item.id, $event.target.value)"
                                                        class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                                    >
                                                        <option value="twitter">Twitter</option>
                                                        <option value="instagram">Instagram</option>
                                                        <option value="linkedin">LinkedIn</option>
                                                        <option value="github">GitHub</option>
                                                        <option value="website">Website</option>
                                                        <option value="mail">Mail</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </template>
                                    </x-ui.card-content>
                                </x-ui.card>
                            </x-ui.tabs-content>
                        </x-ui.tabs>
                    </div>

                    <!-- Preview Panel -->
                    <div class="lg:sticky lg:top-24 lg:h-fit">
                        <x-ui.card class="border-0 shadow-xl rounded-2xl">
                            <x-ui.card-header>
                                <x-ui.card-title class="flex items-center gap-2 text-center justify-center">
                                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    プレビュー
                                </x-ui.card-title>
                            </x-ui.card-header>
                            <x-ui.card-content>
                                <div id="preview-container">
                                    <!-- 動的プレビューカード -->
                                    <div class="w-full max-w-sm mx-auto">
                                        <div 
                                            class="border-0 shadow-2xl overflow-hidden relative rounded-3xl"
                                            :style="`background-color: ${cardData.backgroundColor}`"
                                        >
                                            <!-- Decorative elements -->
                                            <div class="absolute top-4 right-4 opacity-20">
                                                <svg class="w-6 h-6" :style="`color: ${cardData.accentColor}`" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                            </div>
                                            <div class="absolute bottom-4 left-4 opacity-10">
                                                <svg class="w-8 h-8" :style="`color: ${cardData.accentColor}`" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                                </svg>
                                            </div>
                                            <div class="absolute top-8 left-6 opacity-15">
                                                <div class="w-3 h-3 rounded-full" :style="`background-color: ${cardData.accentColor}`"></div>
                                            </div>
                                            <div class="absolute bottom-8 right-6 opacity-15">
                                                <div class="w-2 h-2 rounded-full" :style="`background-color: ${cardData.accentColor}`"></div>
                                            </div>

                                            <div class="p-8 text-center relative z-10">
                                                <!-- Avatar -->
                                                <div class="mb-6">
                                                    <div class="w-24 h-24 mx-auto border-4 border-white shadow-lg rounded-full overflow-hidden">
                                                        <template x-if="cardData.avatar && cardData.avatar !== '/placeholder.svg?height=120&width=120'">
                                                            <img :src="cardData.avatar" :alt="cardData.name" class="aspect-square h-full w-full object-cover" />
                                                        </template>
                                                        <template x-if="!cardData.avatar || cardData.avatar === '/placeholder.svg?height=120&width=120'">
                                                            <div 
                                                                class="flex h-full w-full items-center justify-center rounded-full text-2xl font-bold text-white"
                                                                :style="`background-color: ${cardData.accentColor}`"
                                                                x-text="cardData.name ? cardData.name.charAt(0).toUpperCase() : 'U'"
                                                            ></div>
                                                        </template>
                                                    </div>
                                                </div>

                                                <!-- Name and Title -->
                                                <div class="mb-6">
                                                    <h2 
                                                        class="text-2xl font-bold mb-3" 
                                                        :style="`color: ${cardData.textColor}`"
                                                        x-text="cardData.name || '名前未設定'"
                                                    ></h2>
                                                    <template x-if="cardData.title">
                                                        <div 
                                                            class="inline-flex items-center rounded-full border font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-white border-0 px-4 py-2 text-sm"
                                                            :style="`background-color: ${cardData.accentColor}`"
                                                            x-text="cardData.title"
                                                        ></div>
                                                    </template>
                                                </div>

                                                <!-- Bio -->
                                                <template x-if="cardData.bio">
                                                    <div class="mb-8">
                                                        <p 
                                                            class="text-sm leading-relaxed whitespace-pre-line"
                                                            :style="`color: ${cardData.textColor}; opacity: 0.8`"
                                                            x-text="cardData.bio"
                                                        ></p>
                                                    </div>
                                                </template>

                                                <!-- Email and Phone -->
                                                <div class="mb-6">
                                                    <template x-if="cardData.email">
                                                        <div class="text-sm mb-2" :style="`color: ${cardData.textColor}`">
                                                            <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                            </svg>
                                                            <span x-text="cardData.email"></span>
                                                        </div>
                                                    </template>
                                                    <template x-if="cardData.phone">
                                                        <div class="text-sm" :style="`color: ${cardData.textColor}`">
                                                            <span class="inline-block w-4 h-4 mr-1">📞</span>
                                                            <span x-text="cardData.phone"></span>
                                                        </div>
                                                    </template>
                                                </div>

                                                <!-- Links -->
                                                <template x-if="getVisibleLinks().length > 0">
                                                    <div class="space-y-3">
                                                        <template x-for="item in getVisibleLinks()" :key="item.id">
                                                            <button
                                                                type="button"
                                                                class="w-full justify-between group hover:shadow-lg transition-all duration-200 rounded-2xl border-2 inline-flex items-center whitespace-nowrap text-sm font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2"
                                                                :style="`border-color: ${cardData.accentColor}40; color: ${cardData.textColor}`"
                                                                @click="window.open(item.url, '_blank')"
                                                            >
                                                                <div class="flex items-center gap-3">
                                                                    <svg class="w-5 h-5" :style="`color: ${cardData.accentColor}`" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <template x-if="item.icon === 'mail'">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                                        </template>
                                                                        <template x-if="item.icon !== 'mail'">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9" />
                                                                        </template>
                                                                    </svg>
                                                                    <span class="font-medium" x-text="item.title || item.icon"></span>
                                                                </div>
                                                                <svg class="w-4 h-4 opacity-50 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                                </svg>
                                                            </button>
                                                        </template>
                                                    </div>
                                                </template>

                                                <!-- Footer -->
                                                <div class="mt-8 pt-6 border-t border-gray-200/50">
                                                    <div class="flex items-center justify-center gap-2 text-xs opacity-60">
                                                        <svg class="w-3 h-3" :style="`color: ${cardData.accentColor}`" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                                        </svg>
                                                        <span>Made with NatureLink</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </x-ui.card-content>
                        </x-ui.card>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        function editorData() {
            return {
                cardData: @json($cardData),
                themes: @json($themes),
                
                initEditor() {
                    // プレビュー更新のみに使用
                    this.updatePreview();
                    this.$watch('cardData', () => this.updatePreview(), { deep: true });
                },

                getVisibleLinks() {
                    if (!this.cardData.links || !Array.isArray(this.cardData.links)) {
                        return [];
                    }
                    return this.cardData.links.filter(item => !item.delete);
                },

                updateTheme(themeId) {
                    const theme = this.themes.find(t => t.id === themeId);
                    if (theme) {
                        this.cardData.theme = themeId;
                        this.cardData.backgroundColor = theme.bg;
                        this.cardData.accentColor = theme.accent;
                    }
                },

                addLink() {
                    if (!this.cardData.links) {
                        this.cardData.links = [];
                    }
                    const newLink = {
                        id: Date.now().toString(),
                        title: '',
                        url: '',
                        icon: 'website',
                        delete: false
                    };
                    this.cardData.links.push(newLink);
                },

                removeLink(linkId) {
                    if (!this.cardData.links) return;
                    const linkIndex = this.cardData.links.findIndex(item => item.id === linkId);
                    if (linkIndex !== -1) {
                        this.cardData.links[linkIndex].delete = true;
                    }
                },

                updateLinkIcon(linkId, iconValue) {
                    if (!this.cardData.links) return;
                    const item = this.cardData.links.find(l => l.id === linkId);
                    if (item) {
                        item.icon = iconValue;
                        if (iconValue !== 'website') {
                            item.title = iconValue;
                        }
                    }
                },

                toggleVisibilityAndSubmit() {
                    this.cardData.visibility = !this.cardData.visibility;
                    this.$refs.mainForm.submit();
                },

                updatePreview() {
                    // プレビューの更新処理（リアルタイム表示のみ）
                    try {
                        const previewContainer = document.getElementById('preview-container');
                        if (!previewContainer) {
                            console.warn('Preview container not found');
                            return;
                        }

                        // プレビューアニメーション
                        this.animatePreviewUpdate();

                        console.log('Preview updated successfully', {
                            name: this.cardData.name,
                            theme: this.cardData.theme,
                            linksCount: this.getVisibleLinks().length,
                            visibility: this.cardData.visibility
                        });

                    } catch (error) {
                        console.error('Error updating preview:', error);
                    }
                },

                animatePreviewUpdate() {
                    const previewCard = document.querySelector('#preview-container .rounded-3xl');
                    if (previewCard) {
                        previewCard.classList.add('transform', 'scale-105');
                        setTimeout(() => {
                            previewCard.classList.remove('transform', 'scale-105');
                        }, 200);
                    }
                }
            }
        }
    </script>
    @endpush
@endsection

