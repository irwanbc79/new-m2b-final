{!! '<?xml version="1.0" encoding="UTF-8"?>' . "\n" !!}
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
  <title>M2B Blog — Panduan Ekspor Impor &amp; Logistik</title>
  <link>{{ route('blog.index') }}</link>
  <description>Artikel ekspor, impor, customs clearance, dan tips UMKM dari PT. Mora Multi Berkah (M2B).</description>
  <language>id-ID</language>
  <atom:link href="{{ route('blog.feed') }}" rel="self" type="application/rss+xml" />
@if($posts->isNotEmpty())  <lastBuildDate>{{ $posts->first()->published_at?->toRfc822String() }}</lastBuildDate>
@endif
@foreach($posts as $post)
  <item>
    <title>{{ $post->title }}</title>
    <link>{{ route('blog.show', $post->slug) }}</link>
    <guid isPermaLink="true">{{ route('blog.show', $post->slug) }}</guid>
    <pubDate>{{ $post->published_at?->toRfc822String() }}</pubDate>
@if($post->category)    <category>{{ $post->category }}</category>
@endif
    <description><![CDATA[{!! $post->meta_description !!}]]></description>
  </item>
@endforeach
</channel>
</rss>
