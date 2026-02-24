<div>
    <style>

    </style>

    <div class="form-wrap">
        <div class="form-card">

            <div class="form-top">
                <div class="form-top-icon">
                    <i class="fa-solid fa-house-chimney"></i>
                </div>
                <div class="form-top-text">
                    <h2>New Accommodation</h2>
                    <p>You'll be set as owner automatically.</p>
                </div>
            </div>

            <div class="form-body">

                <div class="field">
                    <label for="name">Name</label>
                    <input
                        type="text"
                        id="name"
                        wire:model="name"
                        placeholder="e.g. Sunset Apartment"
                    />
                    @error('name')
                        <span class="err-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="field">
                    <label for="description">Description</label>
                    <textarea
                        id="description"
                        wire:model="description"
                        placeholder="A short description of the place…"
                    ></textarea>
                    @error('description')
                        <span class="err-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-footer">
                    <button type="button" class="btn btn-ghost">
                        Cancel
                    </button>
                    <button type="button" wire:click="save" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Create
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>