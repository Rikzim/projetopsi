package pt.ipleiria.estg.dei.maislusitania_android;

import android.content.Intent;
import android.graphics.Color;
import android.os.Build;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.webkit.ConsoleMessage;
import android.webkit.WebChromeClient;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import java.io.IOException;

import pt.ipleiria.estg.dei.maislusitania_android.databinding.FragmentMapaBinding;

public class MapaFragment extends Fragment {
    private static final String TAG = "MapaFragment";
    private static final String ASSET_NAME = "leaflet_map.html"; // <-- change if your file is leaflet_mapa.html
    private FragmentMapaBinding binding;

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {
        binding = FragmentMapaBinding.inflate(inflater, container, false);

        binding.tilPesquisa.setEndIconOnClickListener(v -> {
            Intent intent = new Intent(getActivity(), PerfilActivity.class);
            startActivity(intent);
        });

        WebView webView = binding.webViewMap;
        webView.setBackgroundColor(Color.TRANSPARENT);

        WebSettings ws = webView.getSettings();
        ws.setJavaScriptEnabled(true);
        ws.setDomStorageEnabled(true);
        ws.setAllowFileAccess(true);
        ws.setMixedContentMode(WebSettings.MIXED_CONTENT_ALWAYS_ALLOW);

        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.JELLY_BEAN_MR1) {
            ws.setAllowFileAccessFromFileURLs(true);
            ws.setAllowUniversalAccessFromFileURLs(true); // important: lets local file fetch CDN resources / tiles
        }

        webView.setWebViewClient(new WebViewClient());
        webView.setWebChromeClient(new WebChromeClient() {
            @Override
            public boolean onConsoleMessage(ConsoleMessage consoleMessage) {
                Log.d(TAG, "JS: " + consoleMessage.message() + " -- from line "
                        + consoleMessage.lineNumber() + " of " + consoleMessage.sourceId());
                return true;
            }
        });

        // Check asset exists, otherwise load a remote page for quick verification
        try {
            getContext().getAssets().open(ASSET_NAME).close();
            webView.loadUrl("file:///android_asset/" + ASSET_NAME);
            Log.d(TAG, "Loading asset: " + ASSET_NAME);
        } catch (IOException e) {
            Log.e(TAG, "Asset not found: " + ASSET_NAME + " — loading fallback page", e);
            webView.loadUrl("https://www.google.com"); // quick test to confirm WebView works
        }

        return binding.getRoot();
    }

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        if (binding != null && binding.webViewMap != null) {
            WebView w = binding.webViewMap;
            w.loadUrl("about:blank");
            w.stopLoading();
            w.setWebChromeClient(null);
            w.setWebViewClient(null);
            w.destroy();
        }
        binding = null;
    }
}
