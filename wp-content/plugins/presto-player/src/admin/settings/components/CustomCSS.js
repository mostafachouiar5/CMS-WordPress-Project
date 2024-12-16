import { useState, useEffect } from "@wordpress/element";
import { ProgressBar } from "@wordpress/components";

export default ({ content, height, handleChange, editable }) => {
  const [CodeMirror, setCodeMirror] = useState(null);
  const [CSS, setCSS] = useState(null);
  const [isLoading, setIsLoading] = useState(true);

  useEffect(() => {
    const loadModules = async () => {
      try {
        const [CodeMirrorModule, CSSModule] = await Promise.all([
          import("@uiw/react-codemirror"),
          import("@codemirror/lang-css"),
        ]);
        setCodeMirror(() => CodeMirrorModule.default);
        setCSS(() => CSSModule.css);
      } catch (error) {
        console.error("Error loading CodeMirror modules:", error);
      } finally {
        setIsLoading(false);
      }
    };

    loadModules();
  }, []);

  return (
    <>
      {isLoading ? (
        <ProgressBar />
      ) : CodeMirror && CSS ? (
        <CodeMirror
          value={content}
          height={height}
          extensions={[CSS()]}
          onChange={handleChange}
          editable={editable}
        />
      ) : (
        <p>{__("Error loading Code Editor...", "presto-player")}</p>
      )}
    </>
  );
};
