<?php

$file = __DIR__ . '/../resources/views/pages/home.blade.php';
$content = file_get_contents($file);

// Let's search for the exact HTML string of line 2214-2217
$target = '<div style="margin-top:36px;text-align:center">
      <p style="color:#777;font-size:14px;margin-bottom:16px" x-text="$store.lang.t(\'Pertanyaan lain? Tim M2B siap membantu.\', \'Have other questions? The M2B team is ready to help.\', \'还有其他问题？M2B 团队随时为您提供帮助。\', \'هل لديك أسئلة أخرى؟ فريق M2B siap membantu.\')">Pertanyaan lain? Tim M2B siap membantu.</p>
      <a :href="\'https://wa.me/6281263027818?text=\' + encodeURIComponent($store.lang.t(\'Halo M2B, saya punya pertanyaan\', \'Hello M2B, I have a question\', \'您好M2B，我 còn/pertanyaan.\', \'مرحباً M2B, لدي استفسar akhir\'))" target="_blank" style="display:inline-flex;align-items:center;gap:8px;padding:11px 24px;border-radius:8px;background:#1e3a5f;color:#fff;text-decoration:none;font-weight:600;font-size:14px" x-text="$store.lang.t(\'💬 Tanya via WhatsApp\', \'💬 Ask via WhatsApp\', \'💬 通过微信/WhatsApp咨询\', \'💬 اسأل via WhatsApp\')">💬 Tanya via WhatsApp</a>
    </div>';

$replacement = '<div style="margin-top:36px;text-align:center">
      <p style="color:#777;font-size:14px;margin-bottom:16px" x-text="$store.lang.t(\'Pertanyaan lain? Tim M2B siap membantu.\', \'Have other questions? The M2B team is ready to help.\', \'还有其他问题？M2B 团队随时为您提供帮助。\', \'هل لديك أسئلة أخرى؟ فريق M2B siap membantu.\')">Pertanyaan lain? Tim M2B siap membantu.</p>
      <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
        <a :href="\'https://wa.me/6281263027818?text=\' + encodeURIComponent($store.lang.t(\'Halo M2B, saya punya pertanyaan\', \'Hello M2B, I have a question\', \'您好M2B，我 còn/pertanyaan.\', \'مرحباً M2B, لدي استفسar akhir\'))" target="_blank" style="display:inline-flex;align-items:center;gap:8px;padding:11px 24px;border-radius:8px;background:#25D366;color:#fff;text-decoration:none;font-weight:600;font-size:14px;box-shadow:0 4px 12px rgba(37,211,102,0.2)" x-text="$store.lang.t(\'💬 Tanya via WhatsApp\', \'💬 Ask via WhatsApp\', \'💬 通过微信/WhatsApp咨询\', \'💬 اسأل via WhatsApp\')">💬 Tanya via WhatsApp</a>
        <a href="https://t.me/+6281263027818" target="_blank" style="display:inline-flex;align-items:center;gap:8px;padding:11px 24px;border-radius:8px;background:#0088cc;color:#fff;text-decoration:none;font-weight:600;font-size:14px;box-shadow:0 4px 12px rgba(0,136,204,0.2)" x-text="$store.lang.t(\'✈️ Tanya via Telegram\', \'✈️ Ask via Telegram\', \'✈️ 通过 Telegram 咨询\', \'✈️ اسأل عبر تيليجرام\')">✈️ Tanya via Telegram</a>
      </div>
    </div>';

if (strpos($content, $target) !== false) {
    $new_content = str_replace($target, $replacement, $content);
    file_put_contents($file, $new_content);
    echo "Direct replacement succeeded!\n";
} else {
    // If exact match fails, let's try with unified spaces/newlines
    $normalized_content = str_replace("\r\n", "\n", $content);
    $normalized_target = str_replace("\r\n", "\n", $target);
    
    if (strpos($normalized_content, $normalized_target) !== false) {
        $new_content = str_replace($normalized_target, $replacement, $normalized_content);
        file_put_contents($file, $new_content);
        echo "Normalized replacement succeeded!\n";
    } else {
        echo "Error: Target string not found in home.blade.php\n";
    }
}
