@php
    /** @var \App\Models\Product|null $product */

    $product = $product ?? null;

    // Valeurs communes create / edit
    $name        = old('name', $product->name ?? '');
    $price       = old('price', $product->price ?? '');
    $description = old('description', $product->description ?? '');
    $isActive    = (string) old('is_active', $product->is_active ?? 1);
    $sizes       = (array) old('sizes', $product->sizes ?? []);

    // Catégorie courante (pour filtrer les tailles)
    $currentCategory = old('category', $product->category ?? 'vetement');
@endphp

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="admin-form">
    @csrf

    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="admin-form-grid">
        {{-- Colonne gauche --}}
        <div>
            <div class="form-group">
                <label for="name">Nom du produit *</label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ $name }}"
                       required>
            </div>

            <div class="form-group">
                <label for="price">Prix (€) *</label>
                <input type="number"
                       step="0.01"
                       min="0"
                       id="price"
                       name="price"
                       value="{{ $price }}"
                       required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description"
                          name="description"
                          rows="4">{{ $description }}</textarea>
            </div>

            <div class="form-group">
                <label for="image">Image du produit</label>
                <input type="file" id="image" name="image" accept="image/*">
                <p class="field-help">Format JPG / PNG — 5MB max.</p>

                @if($product && $product->image_path)
                    <div class="current-image" style="margin-top:8px;">
                        <span style="font-size:12px;opacity:.7;">Image actuelle :</span>
                        <div style="margin-top:4px;max-width:180px;">
                            <img src="{{ asset('storage/'.$product->image_path) }}"
                                 alt="{{ $product->name }}"
                                 style="width:100%;border-radius:12px;display:block;">
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Colonne droite --}}
        <div>
            {{-- Catégorie d’article (sert à filtrer les tailles) --}}
            <div class="form-group">
                <label for="category">Catégorie d’article *</label>
                <select id="category" name="category" required>
                    <option value="vetement" {{ $currentCategory === 'vetement' ? 'selected' : '' }}>
                        Vêtement (t-shirt, survêt, short…)
                    </option>
                    <option value="gants" {{ $currentCategory === 'gants' ? 'selected' : '' }}>
                        Gants de boxe (oz)
                    </option>
                    <option value="bandes" {{ $currentCategory === 'bandes' ? 'selected' : '' }}>
                        Bandes (mètres)
                    </option>
                    <option value="chaussures" {{ $currentCategory === 'chaussures' ? 'selected' : '' }}>
                        Chaussures (pointures)
                    </option>
                    <option value="protege_dents" {{ $currentCategory === 'protege_dents' ? 'selected' : '' }}>
                        Protège-dents (junior / senior)
                    </option>
                    <option value="autre" {{ $currentCategory === 'autre' ? 'selected' : '' }}>
                        Autre
                    </option>
                </select>
                <p class="field-help">La catégorie sert à afficher les bonnes tailles.</p>
            </div>

            {{-- Tailles dynamiques --}}
            <div class="form-group">
                <label>Tailles disponibles</label>

                @php
                    // Taille -> catégories concernées
                    $allSizeOptions = [
                        // Vêtements
                        'XS'  => ['vetement'],
                        'S'   => ['vetement'],
                        'M'   => ['vetement'],
                        'L'   => ['vetement'],
                        'XL'  => ['vetement'],
                        'XXL' => ['vetement'],

                        // Gants (oz)
                        '6 oz'  => ['gants'],
                        '8 oz'  => ['gants'],
                        '10 oz' => ['gants'],
                        '12 oz' => ['gants'],
                        '14 oz' => ['gants'],
                        '16 oz' => ['gants'],

                        // Bandes (mètres)
                        '2,5 m' => ['bandes'],
                        '3 m'   => ['bandes'],
                        '4 m'   => ['bandes'],
                        '4,5 m' => ['bandes'],

                        // Chaussures (pointures)
                        '36' => ['chaussures'],
                        '37' => ['chaussures'],
                        '38' => ['chaussures'],
                        '39' => ['chaussures'],
                        '40' => ['chaussures'],
                        '41' => ['chaussures'],
                        '42' => ['chaussures'],
                        '43' => ['chaussures'],
                        '44' => ['chaussures'],
                        '45' => ['chaussures'],
                        '46' => ['chaussures'],

                        // Protège-dents
                        'Junior' => ['protege_dents'],
                        'Senior' => ['protege_dents'],
                    ];
                @endphp

                <div class="sizes-grid" id="sizes-grid">
                    @foreach($allSizeOptions as $label => $cats)
                        @php
                            $value   = $label;
                            $checked = in_array($value, $sizes, true);
                        @endphp

                        <label class="size-pill"
                               data-categories="{{ implode(',', $cats) }}">
                            <input type="checkbox"
                                   name="sizes[]"
                                   value="{{ $value }}"
                                {{ $checked ? 'checked' : '' }}>
                            <span>{{ $label }}</span>
                        </label>
                    @endforeach
                </div>

                <p class="field-help">
                    Sélectionne les tailles réellement disponibles.
                </p>
            </div>

            <div class="form-group">
                <label for="is_active">Statut</label>
                <select id="is_active" name="is_active">
                    <option value="1" {{ $isActive === '1' ? 'selected' : '' }}>Visible</option>
                    <option value="0" {{ $isActive === '0' ? 'selected' : '' }}>Caché</option>
                </select>
            </div>
        </div>
    </div>

    <div class="admin-form-actions">
        <a href="{{ route('admin.products.index') }}" class="btn-ghost">Annuler</a>
        <button type="submit" class="btn-primary">{{ $button }}</button>
    </div>
</form>

{{-- Script JS pour filtrer les tailles selon la catégorie --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categorySelect = document.getElementById('category');
        const sizePills = document.querySelectorAll('#sizes-grid .size-pill');

        function refreshSizes() {
            if (!categorySelect) return;

            const cat = categorySelect.value;

            sizePills.forEach(pill => {
                const cats = (pill.dataset.categories || '').split(',');
                const match = cats.includes(cat);

                pill.style.display = match ? 'inline-flex' : 'none';

                if (!match) {
                    const input = pill.querySelector('input[type="checkbox"]');
                    if (input) input.checked = false;
                }
            });
        }

        if (categorySelect) {
            categorySelect.addEventListener('change', refreshSizes);
            refreshSizes(); // premier affichage
        }
    });
</script>
