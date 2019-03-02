import React from 'react';
import News from 'components/common/News';

export default function NewsList(props) {
  if (props.loading) {
    return props.loader;
  }

  return props.news.map(news => (
    <div key={news.url}>
      <News data={news} />
    </div>
  ));
}
