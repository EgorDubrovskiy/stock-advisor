import React from 'react';
import Loading from 'components/common/Loading';

export default function BookmarkButton(props) {
  if (props.loading) {
    return <Loading className="relative" />;
  }

  if (!props.isAuthenticated) {
    return (
      <div className="border">Please sign in to save company to bookmarks</div>
    );
  }
  const companyIsInBookmarks = props.bookmarks.some(
    bookmark => bookmark.company_id === props.companyId
  );
  if (companyIsInBookmarks) {
    return (
      <div className="border bg-green">Company is saved to your bookmarks</div>
    );
  }

  return (
    <button
      className="rounded bt-bg-color bt-font"
      onClick={props.addBookmark(props.companyId)}>
      Add to bookmarks
    </button>
  );
}
