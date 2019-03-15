import React from 'react';
import Loading from 'components/common/Loading';

export default function BookmarkButton(props) {
  if (props.loading) {
    return <Loading className="relative" />;
  }

  if (!props.isAuthenticated) {
    return null;
  }

  const companyIsInBookmarks = props.bookmarks.some(
    bookmark => bookmark.company_id === props.companyId
  );
  if (companyIsInBookmarks) {
    return (
      <div className="border bg-green">Компания сохранена в ваших закладках</div>
    );
  }

  return (
    <button
      className="rounded bt-bg-color bt-font"
      onClick={props.addBookmark(props.companyId)}>
      Добавить в закладки
    </button>
  );
}
