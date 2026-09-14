<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="2.0"
                xmlns:html="http://www.w3.org/TR/REC-html40"
                xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>
    <xsl:template match="/">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <title>XML Sitemap — PT. Mora Multi Berkah (M2B)</title>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <style type="text/css">
                    body {
                        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
                        color: #333333;
                        background-color: #f7f5f0;
                        margin: 0;
                        padding: 30px 20px;
                    }
                    #sitemap {
                        max-width: 1100px;
                        margin: 0 auto;
                        background: #ffffff;
                        padding: 30px;
                        border-radius: 12px;
                        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
                        border: 1px solid #e5e2dc;
                    }
                    h1 {
                        font-size: 26px;
                        color: #1e3a5f;
                        margin-top: 0;
                        margin-bottom: 8px;
                        font-weight: 800;
                    }
                    p.expl {
                        font-size: 14px;
                        color: #666666;
                        margin-bottom: 24px;
                        line-height: 1.6;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        font-size: 13px;
                    }
                    th {
                        background-color: #1e3a5f;
                        color: #ffffff;
                        text-align: left;
                        padding: 12px 14px;
                        font-weight: 600;
                    }
                    th:first-child { border-top-left-radius: 6px; }
                    th:last-child { border-top-right-radius: 6px; }
                    td {
                        padding: 10px 14px;
                        border-bottom: 1px solid #eeeeee;
                    }
                    tr:nth-child(even) { background-color: #fafaf8; }
                    tr:hover { background-color: #f0f4f8; }
                    a {
                        color: #1e3a5f;
                        text-decoration: none;
                        font-weight: 500;
                        word-break: break-all;
                    }
                    a:hover { text-decoration: underline; color: #2a5298; }
                    .priority {
                        font-family: monospace;
                        font-weight: bold;
                        color: #2b7a78;
                    }
                    .badge {
                        display: inline-block;
                        padding: 2px 8px;
                        background: #e8f0fe;
                        color: #1e3a5f;
                        border-radius: 4px;
                        font-size: 11px;
                        font-weight: bold;
                    }
                </style>
            </head>
            <body>
                <div id="sitemap">
                    <h1>XML Sitemap M2B</h1>
                    <p class="expl">
                        Ini adalah XML Sitemap resmi untuk mesin pencari (Google, Bing). Dokumen ini memuat daftar URL kanonis yang dapat diindeks di situs <strong>m2b.co.id</strong>. Total URL terdaftar: <span class="badge"><xsl:value-of select="count(sitemap:urlset/sitemap:url)"/> URL</span>.
                    </p>
                    <table id="sitemap-table">
                        <thead>
                            <tr>
                                <th width="60%">URL Halaman</th>
                                <th width="10%">Prioritas</th>
                                <th width="15%">Frekuensi</th>
                                <th width="15%">Terakhir Diperbarui</th>
                            </tr>
                        </thead>
                        <tbody>
                            <xsl:for-each select="sitemap:urlset/sitemap:url">
                                <tr>
                                    <td>
                                        <xsl:variable name="itemURL">
                                            <xsl:value-of select="sitemap:loc"/>
                                        </xsl:variable>
                                        <a href="{$itemURL}">
                                            <xsl:value-of select="sitemap:loc"/>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="priority">
                                            <xsl:value-of select="concat(sitemap:priority*100, '%')"/>
                                        </span>
                                    </td>
                                    <td>
                                        <xsl:value-of select="sitemap:changefreq"/>
                                    </td>
                                    <td>
                                        <xsl:value-of select="concat(substring(sitemap:lastmod,0,11), ' ', substring(sitemap:lastmod,12,5))"/>
                                    </td>
                                </tr>
                            </xsl:for-each>
                        </tbody>
                    </table>
                </div>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
