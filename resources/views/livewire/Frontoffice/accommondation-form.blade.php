<div>
    <style>
        .form-wrap {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 8px 0;
        }

        .form-card {
            background: var(--bg-2);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            width: 100%;
            max-width: 520px;
            overflow: hidden;
            animation: formIn .4s cubic-bezier(.16,1,.3,1) both;
        }

        @keyframes formIn {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .form-card::before {
            content: '';
            display: block;
            height: 2px;
            background: linear-gradient(90deg, var(--accent), var(--accent-2));
        }

        .form-top {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
        }

        .form-top-icon {
            width: 42px;
            height: 42px;
            border-radius: var(--radius-sm);
            background: var(--accent-dim);
            color: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .form-top-text h2 {
            font-size: 16px;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -.2px;
        }

        .form-top-text p {
            font-size: 12px;
            color: var(--text-3);
            font-family: var(--font-mono);
            margin-top: 2px;
        }

        .form-body {
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .field label {
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--text-3);
        }

        .field input,
        .field textarea {
            width: 100%;
            background: var(--bg-3);
            border: 1px solid var(--border-2);
            border-radius: var(--radius-sm);
            color: var(--text);
            font-family: var(--font-mono);
            font-size: 13px;
            padding: 10px 12px;
            outline: none;
            transition: border-color .15s, box-shadow .15s;
            resize: vertical;
        }

        .field input:focus,
        .field textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-dim);
        }

        .field input::placeholder,
        .field textarea::placeholder { color: var(--text-3); }

        .err-msg {
            font-size: 11px;
            color: var(--danger);
            font-family: var(--font-mono);
        }

        .form-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding-top: 4px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 20px;
            border-radius: var(--radius-sm);
            font-size: 13.5px;
            font-weight: 700;
            font-family: var(--font-display);
            border: 1px solid transparent;
            cursor: pointer;
            transition: background .15s, transform .1s;
        }

        .btn:hover { transform: translateY(-1px); }
        .btn:active { transform: translateY(0); }

        .btn-primary { background: var(--accent); color: #000; }
        .btn-primary:hover { background: var(--accent-2); }

        .btn-ghost {
            background: var(--bg-3);
            color: var(--text-2);
            border-color: var(--border-2);
        }
        .btn-ghost:hover { background: var(--bg-4); color: var(--text); }
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