addEventListener("DOMContentLoaded", () => {
    //URLクエリからresidを取得して指定idへページ内を移動
    const urlParams = new URLSearchParams(window.location.search);
    const resid = urlParams.get("resid");
    const document_resid = resid ? document.getElementById(resid) : null;
    if (document_resid) {
        document_resid.scrollIntoView();
    }

    window.addEventListener("pageshow", function () {
        // すべてのsubmitボタンを取得
        const submitButtons = document.querySelectorAll('[type="submit"]');
        submitButtons.forEach(function (btn) {
            // ボタンを有効化
            btn.disabled = false;
        });
    });

    //JavaScriptによるCookie発行
    const paintform = document.getElementById("paint_form");
    if (paintform instanceof HTMLFormElement) {
        paintform.onsubmit = function () {
            // 二度押し防止
            const submitButton = paintform.querySelector('[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
            }

            const picwInput = paintform.elements.namedItem("picw");
            const pichInput = paintform.elements.namedItem("pich");
            const shiInput = paintform.elements.namedItem("shi");

            if (picwInput instanceof HTMLSelectElement) {
                SetCookie("picwc", picwInput.value);
            }
            if (pichInput instanceof HTMLSelectElement) {
                SetCookie("pichc", pichInput.value);
            }
            if (shiInput instanceof HTMLSelectElement) {
                SetCookie("appletc", shiInput.value);
            }
        };
    }
    const commentform = document.getElementById("comment_form");
    if (commentform instanceof HTMLFormElement) {
        commentform.onsubmit = function () {
            // 二度押し防止
            const submitButton = commentform.querySelector('[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
            }
            const nameInput = commentform.elements.namedItem("name");
            const urlInput = commentform.elements.namedItem("url");
            const pwdInput = commentform.elements.namedItem("pwd");

            if (nameInput instanceof HTMLInputElement) {
                SetCookie("namec", nameInput.value);
            }
            if (urlInput instanceof HTMLInputElement) {
                SetCookie("urlc", urlInput.value);
            }
            if (pwdInput instanceof HTMLInputElement) {
                SetCookie("pwdc", pwdInput.value);
            }
        };
    }
    function SetCookie(key, val) {
        document.cookie =
            key + "=" + encodeURIComponent(val) + ";max-age=31536000;";
    }

    //スマホの時はPC用のメニューを非表示
    if (navigator.maxTouchPoints && screen.width < 600) {
        const for_mobile = document.getElementById("for_mobile");
        if (for_mobile) {
            for_mobile.textContent = ".for_pc{display: none;}";
        }
    }
    //動画保存するアプリと保存しないアプリの時の表示切り替え

    const toggleHideAnimation = (usePlayback) => {
        const save_playback = document.getElementById("save_playback");
        if (save_playback) {
            save_playback.style.display = usePlayback ? "inline-block" : "none";
        }
    };
    const select_app = document.getElementById("select_app");
    // セレクトメニューの変更イベント
    if (select_app instanceof HTMLSelectElement) {
        const usePlaybackApps = ["neo", "tegaki", "1", "2"];

        select_app.addEventListener("change", (e) => {
            toggleHideAnimation(usePlaybackApps.includes(e.target?.value));
        });

        // 初期値の設定を反映
        toggleHideAnimation(usePlaybackApps.includes(select_app.value));
    }
});
//shareするSNSのserver一覧を開く
var snsWindow = null; // グローバル変数としてウィンドウオブジェクトを保存する

function open_sns_server_window(event, width = 600, height = 600) {
    event.preventDefault(); // デフォルトのリンクの挙動を中断

    // 幅と高さが数値であることを確認
    // 幅と高さが正の値であることを確認
    if (isNaN(width) || width <= 350 || isNaN(height) || height <= 400) {
        width = 350; //デフォルト値
        height = 400; //デフォルト値
    }
    var url = event.currentTarget.href;
    var windowFeatures = "width=" + width + ",height=" + height; // ウィンドウのサイズを指定

    if (snsWindow && !snsWindow.closed) {
        snsWindow.focus(); // 既に開かれているウィンドウがあればフォーカスする
    } else {
        snsWindow = window.open(url, "_blank", windowFeatures); // 新しいウィンドウを開く
    }
    // ウィンドウがフォーカスを失った時の処理
    snsWindow.addEventListener("blur", function () {
        if (snsWindow.location.href === url) {
            snsWindow.close(); // URLが変更されていない場合はウィンドウを閉じる
        }
    });
}
document.addEventListener("DOMContentLoaded", () => {
    const pagetop = document.getElementById("page_top");
    let scrollTimeout; // スクロールが停止したタイミングをキャッチするタイマー
    if (!pagetop) {
        return; // pagetopが存在しない場合は処理を終了
    }
    // 初期状態で非表示
    pagetop.style.visibility = "hidden"; // 初期状態で非表示
    pagetop.style.opacity = getComputedStyle(pagetop).opacity; // 初期opacityをCSSの設定値に設定

    // CSSで設定されているopacityの値を動的に取得（上限として使用）
    const maxOpacity = parseFloat(getComputedStyle(pagetop).opacity);

    // フェードイン/フェードアウトを管理する関数
    const fade = (el, to, duration = 500) => {
        const startOpacity = parseFloat(el.style.opacity);
        let startTime = performance.now();

        function fadeStep(now) {
            const elapsed = now - startTime;
            const progress = Math.min(elapsed / duration, 1);
            let opacity = startOpacity + (to - startOpacity) * progress;

            // opacityの上限をmaxOpacity（CSSで指定された値）に設定
            opacity = opacity > maxOpacity ? maxOpacity : opacity; // 上限を超えないようにする

            el.style.opacity = opacity.toFixed(2);

            if (progress < 1) {
                requestAnimationFrame(fadeStep);
            } else {
                if (to === 0) {
                    el.style.visibility = "hidden"; // 完全にフェードアウトしたら非表示
                }
            }
        }

        if (to === 1) {
            el.style.visibility = "visible"; // フェードインで表示
        }

        requestAnimationFrame(fadeStep);
    };

    // スクロール時の処理
    window.addEventListener("scroll", () => {
        // スクロール開始後に表示
        if (window.scrollY > 100 && pagetop?.style.visibility === "hidden") {
            fade(pagetop, 1, 500); // 0.5秒でフェードイン
        }

        // スクロール停止後に非表示
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(() => {
            if (window.scrollY <= 100) {
                fade(pagetop, 0, 200); // 0.2秒でフェードアウト
            }
        }, 200); // 200msの遅延で非表示
    });

    // スムーススクロール
    function smoothScrollToTop(duration = 500) {
        // 0.5秒かけてスクロール
        const start = window.scrollY;
        const startTime = performance.now();

        function scrollStep(now) {
            const elapsed = now - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const ease = 1 - Math.pow(1 - progress, 3); // ease-out効果

            window.scrollTo(0, start * (1 - ease));

            if (progress < 1) {
                requestAnimationFrame(scrollStep);
            } else {
                fade(pagetop, 0, 500); // スクロール完了後にフェードアウト
            }
        }

        requestAnimationFrame(scrollStep);
    }

    // トップに戻るボタンがクリックされたとき
    pagetop?.addEventListener("click", (e) => {
        e.preventDefault();
        smoothScrollToTop(500); // 0.5秒でスクロール
    });
});

jQuery(function () {
    //Lightbox
    if (typeof lightbox !== "undefined") {
        lightbox.option({
            alwaysShowNavOnTouchDevices: true,
            disableScrolling: true,
            fadeDuration: 0,
            resizeDuration: 500,
            imageFadeDuration: 500,
            wrapAround: true,
        });
    }
});
