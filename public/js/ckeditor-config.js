/**
 * CKEditor 5 Configuration for Laravel Admin Panel
 * This configuration was generated using the CKEditor 5 Builder.
 */

// License Key
const CKEDITOR_LICENSE_KEY = 'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3NjU5Mjk1OTksImp0aSI6IjMxYjcxZDE2LWUwYWUtNDY3MC05N2I0LTNlNzY3ODA0YTg5YiIsInVzYWdlRW5kcG9pbnQiOiJodHRwczovL3Byb3h5LWV2ZW50LmNrZWRpdG9yLmNvbSIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsiY2xvdWQiLCJkcnVwYWwiLCJzaCJdLCJ3aGl0ZUxhYmVsIjp0cnVlLCJsaWNlbnNlVHlwZSI6InRyaWFsIiwiZmVhdHVyZXMiOlsiKiJdLCJ2YyI6Ijg0YzRkY2I0In0.UdDorU0XdHYNxd8u6cwXzSmuxewmhZCzizD-B8fMMWQuz2pjxzAjQMdjGyX2i7cJ-I8jh8jzYDNFAT1vhJsVCQ';

// Default hex colors for color pickers
const DEFAULT_HEX_COLORS = [
    { color: '#000000', label: 'Black' },
    { color: '#4D4D4D', label: 'Dim grey' },
    { color: '#999999', label: 'Grey' },
    { color: '#E6E6E6', label: 'Light grey' },
    { color: '#FFFFFF', label: 'White', hasBorder: true },
    { color: '#E65C5C', label: 'Red' },
    { color: '#E69C5C', label: 'Orange' },
    { color: '#E6E65C', label: 'Yellow' },
    { color: '#C2E65C', label: 'Light green' },
    { color: '#5CE65C', label: 'Green' },
    { color: '#5CE6A6', label: 'Aquamarine' },
    { color: '#5CE6E6', label: 'Turquoise' },
    { color: '#5CA6E6', label: 'Light blue' },
    { color: '#5C5CE6', label: 'Blue' },
    { color: '#A65CE6', label: 'Purple' }
];

/**
 * Get CKEditor configuration
 * @param {string} initialData - Initial content for the editor
 * @returns {Object} CKEditor configuration object
 */
function getCKEditorConfig(initialData = '') {
    // Check if CKEditor is loaded
    if (typeof window.CKEDITOR === 'undefined') {
        console.error('CKEditor 5 is not loaded. Please include the CKEditor scripts.');
        return null;
    }

    const {
        ClassicEditor,
        Autosave,
        Essentials,
        Paragraph,
        Autoformat,
        TextTransformation,
        LinkImage,
        Link,
        ImageBlock,
        ImageToolbar,
        BlockQuote,
        Bold,
        Bookmark,
        CKBox,
        CloudServices,
        ImageUpload,
        ImageInsert,
        ImageInsertViaUrl,
        AutoImage,
        PictureEditing,
        CKBoxImageEdit,
        TableColumnResize,
        Table,
        TableToolbar,
        Emoji,
        Mention,
        PasteFromOffice,
        FindAndReplace,
        FontBackgroundColor,
        FontColor,
        FontFamily,
        FontSize,
        Fullscreen,
        Heading,
        Highlight,
        HorizontalLine,
        ImageTextAlternative,
        ImageCaption,
        ImageResize,
        ImageStyle,
        Indent,
        IndentBlock,
        Code,
        ImageInline,
        Italic,
        AutoLink,
        ListProperties,
        List,
        ImageUtils,
        ImageEditing,
        PageBreak,
        RemoveFormat,
        SpecialCharactersArrows,
        SpecialCharacters,
        SpecialCharactersCurrency,
        SpecialCharactersEssentials,
        SpecialCharactersLatin,
        SpecialCharactersMathematical,
        SpecialCharactersText,
        Strikethrough,
        Subscript,
        Superscript,
        TableCaption,
        TableCellProperties,
        TableProperties,
        Alignment,
        TodoList,
        Underline,
        ShowBlocks,
        GeneralHtmlSupport,
        HtmlEmbed,
        HtmlComment,
        FullPage,
        TextPartLanguage,
        WordCount,
        Title,
        BalloonToolbar,
        BlockToolbar
    } = window.CKEDITOR;

    const {
        CaseChange,
        PasteFromOfficeEnhanced,
        ExportPdf,
        ExportWord,
        Footnotes,
        FormatPainter,
        ImportWord,
        LineHeight,
        MergeFields,
        MultiLevelList,
        SlashCommand,
        TableOfContents,
        Template,
        SourceEditingEnhanced,
        EmailConfigurationHelper
    } = window.CKEDITOR_PREMIUM_FEATURES || {};

    return {
        toolbar: {
            items: [
                'undo',
                'redo',
                '|',
                'heading',
                '|',
                'fontSize',
                'fontFamily',
                'fontColor',
                'fontBackgroundColor',
                '|',
                'bold',
                'italic',
                'underline',
                '|',
                'link',
                'insertImage',
                'insertTable',
                'highlight',
                'blockQuote',
                '|',
                'alignment',
                'lineHeight',
                '|',
                'bulletedList',
                'numberedList',
                'multiLevelList',
                'todoList',
                'outdent',
                'indent',
                '|',
                'code',
                'sourceEditingEnhanced',
                '|',
                'fullscreen'
            ],
            shouldNotGroupWhenFull: false
        },
        plugins: [
            Alignment,
            Autoformat,
            AutoImage,
            AutoLink,
            Autosave,
            BalloonToolbar,
            BlockQuote,
            BlockToolbar,
            Bold,
            Bookmark,
            CKBox,
            CKBoxImageEdit,
            CloudServices,
            Code,
            Emoji,
            Essentials,
            ExportPdf,
            ExportWord,
            FindAndReplace,
            FontBackgroundColor,
            FontColor,
            FontFamily,
            FontSize,
            Footnotes,
            FormatPainter,
            FullPage,
            Fullscreen,
            GeneralHtmlSupport,
            Heading,
            Highlight,
            HorizontalLine,
            HtmlComment,
            HtmlEmbed,
            ImageBlock,
            ImageCaption,
            ImageEditing,
            ImageInline,
            ImageInsert,
            ImageInsertViaUrl,
            ImageResize,
            ImageStyle,
            ImageTextAlternative,
            ImageToolbar,
            ImageUpload,
            ImageUtils,
            ImportWord,
            Indent,
            IndentBlock,
            Italic,
            LineHeight,
            Link,
            LinkImage,
            List,
            ListProperties,
            Mention,
            MergeFields,
            MultiLevelList,
            PageBreak,
            Paragraph,
            PasteFromOffice,
            PasteFromOfficeEnhanced,
            PictureEditing,
            RemoveFormat,
            ShowBlocks,
            SlashCommand,
            SourceEditingEnhanced,
            SpecialCharacters,
            SpecialCharactersArrows,
            SpecialCharactersCurrency,
            SpecialCharactersEssentials,
            SpecialCharactersLatin,
            SpecialCharactersMathematical,
            SpecialCharactersText,
            Strikethrough,
            Subscript,
            Superscript,
            Table,
            TableCaption,
            TableCellProperties,
            TableColumnResize,
            TableOfContents,
            TableProperties,
            TableToolbar,
            Template,
            TextPartLanguage,
            TextTransformation,
            Title,
            TodoList,
            Underline,
            WordCount
        ].filter(Boolean), // Remove undefined plugins
        balloonToolbar: ['bold', 'italic', '|', 'link', 'insertImage', '|', 'bulletedList', 'numberedList'],
        blockToolbar: [
            'fontSize',
            'fontColor',
            'fontBackgroundColor',
            '|',
            'bold',
            'italic',
            '|',
            'link',
            'insertImage',
            'insertTable',
            '|',
            'bulletedList',
            'numberedList',
            'outdent',
            'indent'
        ],
        fontBackgroundColor: {
            colorPicker: {
                format: 'hex'
            },
            colors: DEFAULT_HEX_COLORS
        },
        fontColor: {
            colorPicker: {
                format: 'hex'
            },
            colors: DEFAULT_HEX_COLORS
        },
        fontFamily: {
            supportAllValues: true
        },
        fontSize: {
            options: [10, 12, 14, 'default', 18, 20, 22],
            supportAllValues: true
        },
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
            ]
        },
        htmlSupport: {
            allow: [
                {
                    name: /^(div|table|tbody|tr|td|span|img|h1|h2|h3|h4|h5|h6|p|a|ul|ol|li|strong|em|u|s|code|blockquote|hr)$/,
                    styles: true,
                    attributes: true,
                    classes: true
                }
            ]
        },
        image: {
            toolbar: [
                'toggleImageCaption',
                'imageTextAlternative',
                '|',
                'imageStyle:inline',
                'imageStyle:wrapText',
                'imageStyle:breakText',
                '|',
                'resizeImage',
                '|',
                'ckboxImageEdit'
            ]
        },
        initialData: initialData,
        licenseKey: CKEDITOR_LICENSE_KEY,
        lineHeight: {
            supportAllValues: true
        },
        link: {
            addTargetToExternalLinks: true,
            defaultProtocol: 'https://',
            decorators: {
                toggleDownloadable: {
                    mode: 'manual',
                    label: 'Downloadable',
                    attributes: {
                        download: 'file'
                    }
                }
            }
        },
        list: {
            properties: {
                styles: true,
                startIndex: true,
                reversed: false
            }
        },
        placeholder: 'Type or paste your content here!',
        table: {
            contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties'],
            tableProperties: {
                borderColors: DEFAULT_HEX_COLORS,
                backgroundColors: DEFAULT_HEX_COLORS
            },
            tableCellProperties: {
                borderColors: DEFAULT_HEX_COLORS,
                backgroundColors: DEFAULT_HEX_COLORS
            }
        }
    };
}

/**
 * Initialize CKEditor on a textarea element
 * @param {string|HTMLElement} textareaIdOrElement - ID of textarea or element itself
 * @returns {Promise} Promise that resolves with the editor instance
 */
async function initCKEditor(textareaIdOrElement) {
    const textarea = typeof textareaIdOrElement === 'string' 
        ? document.getElementById(textareaIdOrElement)
        : textareaIdOrElement;

    if (!textarea) {
        console.error('Textarea element not found');
        return null;
    }

    // Check if CKEditor is loaded
    if (typeof window.CKEDITOR === 'undefined') {
        console.error('CKEditor 5 is not loaded. Please include the CKEditor scripts.');
        return null;
    }

    const { ClassicEditor } = window.CKEDITOR;
    const initialData = textarea.value || '';
    const config = getCKEditorConfig(initialData);

    if (!config) {
        return null;
    }

    try {
        const editor = await ClassicEditor.create(textarea, config);
        
        // Sync editor content with textarea before form submission
        const form = textarea.closest('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                textarea.value = editor.getData();
            });
        }

        return editor;
    } catch (error) {
        console.error('Error initializing CKEditor:', error);
        return null;
    }
}

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { getCKEditorConfig, initCKEditor, CKEDITOR_LICENSE_KEY };
}

